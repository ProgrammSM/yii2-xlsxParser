<?php
$db = require(__DIR__ . '/db.php');
$pathDB = realpath(__DIR__ . '/../tests/_data') . '/data.db';
$db['dsn'] = 'sqlite:' . $pathDB;

return $db;
