<?php

namespace src\Integration;

use src\ConfigInterface;

/**
 * Class HttpDataProvider
 *
 * Getting data using HTTP
 */
class HttpDataProvider implements DataProviderInterface
{
    protected $host;
    protected $user;
    protected $password;

    /**
     * @param Config $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->host = $config->get('host');
        $this->user = $config->get('user');
        $this->password = $config->get('password');
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request)
    {
        // returns a response from external service
    }
}
