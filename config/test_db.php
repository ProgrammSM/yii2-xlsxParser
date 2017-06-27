<?php
/**
 * Конфигурация базы данных SQLite в директории @app/tests/_data
 */
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . realpath(__DIR__ . '/../tests/_data') . '/data.db',
];
