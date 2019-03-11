<?php

/**
 * Задание: 
 *     Реализовать счетчик вызова скрипта. 
 *     Было принято решение, хранить данные в файле.
 */
 
set_exception_handler(function($e) {
	// Куда-нибудь логгируется
	echo "Exception: " . $e->getMessage() . "\n";
	exit(1);
});

$filename = './counter.txt';

if (!file_exists($filename)) {
	throw new \Exception('Counter file is not exists.');
}

$data = trim(file_get_contents($filename));

if (preg_match('/^\d+$/', $data) !== 1) {
	throw new \Exception('Counter file contents is not a valid decimal.');
}

$count = bcadd($data, 1);

if (file_put_contents($filename, $count, LOCK_EX) === FALSE) {
	throw new \Exception('There was error while saving counter value.');
}

echo "Successfull";
