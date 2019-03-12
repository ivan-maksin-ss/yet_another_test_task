<?php

/**
 * Задание: 
 *     Реализовать счетчик вызова скрипта. 
 *     Было принято решение, хранить данные в файле.
 */

/**
 * PHP должен быть запущен с включенной настройкой --enable-bcmath
 */

set_exception_handler(function($e) {
	// Куда-нибудь логгируется для ручного контроля
	echo "Exception: " . $e->getMessage() . "\n";

	// Завершение работы с ненулевым кодом
	exit(1);
});

$filename = './counter2.txt';

if (!file_exists($filename) && !touch($filename)) {
	throw new \Exception('Counter file is not found and cannot be created.');
}

if (!is_readable($filename)) {
	throw new \Exception('Counter file is not readable.');
}

if (!is_writable($filename)) {
	throw new \Exception('Counter file is not writable.');
}

$data = trim(file_get_contents($filename));
if (empty($data)) {
    $data = '0';
} else {
    if (!ctype_digit($data)) {
        throw new \Exception('Counter file contents is not a valid decimal.');
    }
}

$count = bcadd($data, 1);

if (file_put_contents($filename, $count, LOCK_EX) === FALSE) {
	throw new \Exception('There was error while saving counter value.');
}

exit(0);
