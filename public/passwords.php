<?php

$password = 'pass';
$hash = password_hash($password, PASSWORD_BCRYPT);
var_dump($hash);

$verified = password_verify($password, $hash);
var_dump($verified);

$verified = password_verify('test', $hash);
var_dump($verified);
