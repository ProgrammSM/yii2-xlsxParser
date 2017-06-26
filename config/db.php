<?php
/**
 * Конфигурация базы данных SQLite в директории @app/data/
 */
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . realpath(__DIR__ . '/../data') . '/data.db',
];
