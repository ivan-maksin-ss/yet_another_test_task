<?php

namespace src\Decorator;

use src\Integration\DataProviderInterface;

class DataProviderDecorator implements DataProviderInterface
{
    /** @var DataProviderInterface */
    protected $dataProvider;

    /**
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $input)
    {
        return $this->dataProvider->get($input);
    }
}
