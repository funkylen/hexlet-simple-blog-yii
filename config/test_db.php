<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'pgsql:host=postgres;dbname=yii_test';
$db['username'] = 'yii';
$db['password'] = 'secret';

return $db;
