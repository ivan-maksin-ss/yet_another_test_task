<?php

namespace src\Integration;

interface DataProviderInterface
{
    /**
     * Получает данные согласно переданным параметрам.
     *
     * @param array $request
     *
     * @return array
     */
    public function get(array $request);
}
