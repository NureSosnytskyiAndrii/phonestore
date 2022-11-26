<?php

/** Database configuration BEGIN **/

const DB_HOST = 'localhost'; //Host
const DB_NAME = 'phonestore'; //Database name
const DB_USER = 'root'; //Database user
const DB_PASSWORD = 'root'; //Database password

/** Database configuration END **/

$mysqli = new mysqli();
$mysqli->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli -> connect_errno) exit('Ошибка подлючения к бд');
$mysqli -> set_charset('utf8');
