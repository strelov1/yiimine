<?php
return [
    'adminDashboard' => [
        'type' => 2,
    ],
    'viewProject' => [
        'type' => 2,
        'description' => 'View project',
        'ruleName' => 'isCreator',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'children' => [
            'viewProject',
        ],
    ],
    'reporter' => [
        'type' => 1,
        'description' => 'Репортер',
        'children' => [
            'user',
        ],
    ],
    'developer' => [
        'type' => 1,
        'description' => 'Программист',
        'children' => [
            'reporter',
        ],
    ],
    'manager' => [
        'type' => 1,
        'description' => 'Менеджер',
        'children' => [
            'developer',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Админ',
        'children' => [
            'manager',
            'adminDashboard',
        ],
    ],
];
