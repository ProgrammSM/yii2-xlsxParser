<?php
$dbPath = realpath(__DIR__ . '/../data');

return [
    'adminEmail' => 'admin@example.com',
    // базовая зарплатная ставка за один час
    'rate' => 500.0,
    // путь до расположения базы данных
    'dbPath' => $dbPath,
];
