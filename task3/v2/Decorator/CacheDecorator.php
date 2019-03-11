<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\ConfigInterface;

class CacheDecorator extends DataProviderDecorator
{
    /** @var CacheItemPoolInterface  */
    protected $cache;

    /** @var LoggerInterface*/
    protected $logger;

    /** @var ConfigInterface*/
    protected $config;

    /**
     * {@inheritdoc}
     */
    public function get(array $input)
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->dataProvider->get($input);

            if ($this->isCacheable($result)) {
                $expires = (new DateTime())->modify('+' . $this->config->get('cache_days', 1) . ' day');
                $cacheItem
                    ->set($result)
                    ->expiresAt($expires);
            }

            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Gets unique cache key.
     *
     * @param array $input
     * @return string
     */
    protected function getCacheKey(array $input)
    {
        $key = '';
        // Здесь какая-то хитрая логика получения ключа...

        return md5($key);
    }

    /**
     * Checks if data is able to cache.
     * For example, for the HTTP response checks response code.
     *
     * @param array $data
     * @return bool
     */
    protected function isCacheable(array $data)
    {
        return true;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param CacheItemPoolInterface $cache
     */
    public function setCache(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheItemPoolInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config): void
    {
        $this->config = $config;
    }
}
