<?php

$host = "localhost:3306";
$user = "sowa_user";
$passwd = "PqKk6EyCYaJsZQSC";
$dbName = "sowa";

$link = mysqli_connect($host, $user, $passwd, $dbName) or showError(mysqli_error($link));
