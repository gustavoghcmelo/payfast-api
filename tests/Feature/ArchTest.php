<?php

test('the helpers [dd, die, dump, ray] must not be present in the code')
    ->expect('App')
    ->not->toUse(['die', 'dd', 'dump', 'ray']);
