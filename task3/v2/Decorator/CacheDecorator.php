<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class CacheDecorator extends DataProviderDecorator
{
    /** @var CacheItemPoolInterface  */
    protected $cache;

    /** @var LoggerInterface*/
    protected $logger;

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
                $cacheItem
                    ->set($result)
                    ->expiresAt(
                        (new DateTime())->modify('+1 day')
                    );
            }

            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error');
        }

        return [];
    }

    /**
     * Gets unique cache key.
     *
     * @param array $input
     * @return false|string
     */
    protected function getCacheKey(array $input)
    {
        if ($key = \json_encode($input)) {
            return md5($key);
        }

        return false;
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
}
