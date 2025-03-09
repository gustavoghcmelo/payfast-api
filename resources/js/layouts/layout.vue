<template>
    <q-layout view="hHh LpR fFf" class="text-primary">

        <q-header bordered class="bg-transparent">
            <q-toolbar>
                <q-btn
                    :color="$q.dark.isActive ? 'primary' : 'dark'"
                    dense flat round icon="menu"
                    @click="toggleLeftDrawer"
                />

                <q-img width="100px" src="/img/logo_white.png"/>
            </q-toolbar>
        </q-header>

        <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
            <!-- drawer content -->
        </q-drawer>

        <q-page-container>
            <div class="q-pa-md">
                <slot></slot>
            </div>
        </q-page-container>

    </q-layout>
</template>

<script setup lang="ts">
import type { Ref } from 'vue';
import { ref } from 'vue';

const leftDrawerOpen: Ref = ref(false)
const toggleLeftDrawer = () => leftDrawerOpen.value = !leftDrawerOpen.value
</script>
