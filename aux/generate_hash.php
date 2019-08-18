<?php
$time  = time();
echo "Time: $time".PHP_EOL."Hash: ".sha1($argv[1].$time.'texto Secreto! cualquier cosa aqui') . PHP_EOL;