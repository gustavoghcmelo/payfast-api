<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateGateway extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:gateway {name : O nome do gateway (ex: Stripe, PayPal)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um novo gateway de pagamento no projeto.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $gatewayName = Str::studly($name);
        $gatewaySlug = Str::kebab($gatewayName);

        $this->createGatewayClass($gatewayName);

        $this->addGatewayToConfig($gatewayName, $gatewaySlug);
    }

    protected function createGatewayClass(string $gatewayName): void
    {
        if ($this->gatewayClassExists($gatewayName)) {
            $this->warn("A classe do gateway '$gatewayName' já existe!");
            return;
        }

        $stub = File::get(app_path('Console/Commands/stubs/gateway.stub'));
        $stub = str_replace('{{GatewayName}}', $gatewayName, $stub);

        $path = app_path("Gateways/{$gatewayName}Gateway.php");

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $stub);

        $this->info("Classe do gateway criada em: $path");
    }

    protected function addGatewayToConfig(string $gatewayName, string $gatewaySlug): void
    {
        $configPath = config_path('gateway.php');
        $configContent = File::get($configPath);

        if (str_contains($configContent, "'$gatewaySlug'") !== false) {
            $this->warn("O gateway '$gatewayName' já existe no arquivo de configuração.");
            return;
        }

        $slug = Str::slug($gatewaySlug);
        $newGatewayEntry = "        '$slug' => \\App\\Gateways\\{$gatewayName}Gateway::class,";
        $configContent = preg_replace(
            '/\'gateways\' => \[/',
            "'gateways' => [\n$newGatewayEntry",
            $configContent
        );

        File::put($configPath, $configContent);
        $this->info("Gateway '$gatewayName' adicionado ao arquivo de configuração.");
    }

    protected function gatewayClassExists(string $gatewayName): bool
    {
        $path = app_path("Gateways/{$gatewayName}Gateway.php");
        return File::exists($path);
    }
}
