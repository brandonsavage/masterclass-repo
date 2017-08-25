<?php

$path = realpath(__DIR__ . '/../views');

return [
    'layouts' => [
        'layout' => $path . '/layout.php',
    ],

    'templates' => [
        'index' => $path . '/index.php',
        'storyIndex' => $path . '/storyIndex.php',
        'storyCreate' => $path . '/storyCreate.php',
        'userLogin' => $path . '/userLogin.php',
        'userCreate' => $path . '/userCreate.php',
        'userAccount' => $path . '/userAccount.php',
    ],
];