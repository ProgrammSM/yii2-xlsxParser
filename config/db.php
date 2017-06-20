<?php
/**
 * Конфигурация базы данных SQLite в директории @app/data/data.db
 */
$pathDB = realpath(__DIR__ . '/../data') . '/data.db';

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . $pathDB,
];
