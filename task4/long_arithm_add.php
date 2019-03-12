<?php

/**
 * Складывает целые положительные числа заданные в десятичной записи.
 *
 * @param string $a Слагаемое
 * @param string $b Слагаемое
 * @return string Сумма
 *
 * @throws Exception
 */
function longAdd(string $a, string $b) {
	// check if numbers are from digits
	if (preg_match('/^\d+$/', $a) !==1 || preg_match('/^\d+$/', $b) !== 1) 
	{
		throw new \Exception("At least one number is not a valid integer value.");
	}
	
	// Максимальный размер количества цифр в группе
	$chunkSize = strlen(strval(PHP_INT_MAX))-1;
	
	// Удаление ведущих нулей
	$a = ltrim($a, '0');
	$b = ltrim($b, '0');
	
	// Определение минимальной длины кратной группе
	$aLen = strlen($a);
	$bLen = strlen($b);

	$maxLen = max([$aLen, $bLen]);
	$len = ceil($maxLen/$chunkSize)*$chunkSize;

	// Добивка нулями до размера кратному группе
	$a = str_pad($a, $len, '0', STR_PAD_LEFT);
	$b = str_pad($b, $len, '0', STR_PAD_LEFT);
	
	// Компоновка соответствующих групп двух чисел
	$chunks = array_reverse(
		array_map(
			null, 
			str_split($a, $chunkSize), 
			str_split($b, $chunkSize)
		)
	);

	// Сложение чисел в группах
	$carry = 0;
	$result = '';
	$chunksMod = pow(10, $chunkSize);
	$chunkSign = 1;
	foreach($chunks as $chunk) {
		// Складываются частичные суммы и результат переноса предыдущей операции 
		$chunkSum = intval($chunk[0]) + intval($chunk[1]) + $carry;
		
		// Сложение
		$result = str_pad(
			strval(abs($chunkSum)%$chunksMod), 
			$chunkSize, 
			'0', 
			STR_PAD_LEFT
		) . $result;
		
		// Перенос операции
		$carry = intdiv($chunkSum, $chunksMod);
	}
	
	// Удаление ведущих нулей в итоговой сумме
	return ltrim($carry . $result, '0');
}


/**
 * Генерирует целое число указанной длины в десятичной записи.
 *
 * @param $len
 * @return string
 */
function randomDecimal($len)
{
	$result = '';
	while ($len--) 
	{
		$result .= rand(0,9);
	}

	return $result;
}


// Testing
$testsCount = 1e2;

while ($testsCount--) {
	$a = randomDecimal(rand(50, 100));
	$b = randomDecimal(rand(50, 100));

	$result = longAdd($a, $b);
	$etalon = bcadd($a, $b);

	if ($result !== $etalon) {
		echo "- \n: $a;\n: $b;\n: $result;\n: $etalon\n";
	} else {
		echo "+\n";
	}
}

