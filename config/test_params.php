<?php
$params = require(__DIR__ . '/params.php');
$params['dbPath'] = realpath(__DIR__ . '/../tests/_data');

return $params;
