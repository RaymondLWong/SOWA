<?php

$host = "mysql.cms.gre.ac.uk";
$user = "wr305";
$passwd = "wr305";
$dbName = "wr305";

$link = mysqli_connect($host, $user, $passwd, $dbName) or die(mysqli_error($link));