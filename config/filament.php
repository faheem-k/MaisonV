<?php

return [
    // Admin panel path (use 'filament' to avoid conflicting with custom /admin routes)
    'path' => env('FILAMENT_PATH', 'filament'),

    // Minimal panel configuration so CLI generators can run.
    'panels' => [
        'default' => [
            'id' => 'default',
            'label' => 'Admin',
        ],
    ],
];
