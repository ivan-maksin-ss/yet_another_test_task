<?php

namespace src;

interface ConfigInterface
{
    /**
     * Возвращает значения по имени параметра.
     *
     * @param $key
     * @return mixed
     */
    public function get($key);
}