<?php


namespace ziya\RedisRateLimiter;


use yii\redis\Connection;
use ziya\RedisRateLimiter\exceptions\LimitExceeded;

class Limiter
{
    private string $key_prefix;
    private int $count;
    private int $interval;
    /**
     * @var Connection
     */
    private $redis;

    /**
     * Limiter constructor.
     * @param string $key_prefix
     * @param int $count
     * @param int $interval
     */
    public function __construct(string $key_prefix, int $count, int $interval)
    {
        $this->key_prefix = $key_prefix;
        $this->count = $count;
        $this->interval = $interval;
    }

    public function setConnection(Connection $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws LimitExceeded
     */
    public function limit(): void
    {
        if ($this->redis == null) {
            $this->redis = \Yii::$app->redis;
        }
        $key = "{$this->interval}--{$this->key_prefix}";

        $requestCount = (int)$this->redis->get($key);

        if ($requestCount >= $this->count) {
            throw new LimitExceeded($this->count, $this->interval);
        }
        $this->updateValue($key, $this->interval);
    }

    private function updateValue(string $key, int $interval)
    {
        $requestCount = $this->redis->incr($key);
        if ($requestCount === 1) {
            $this->redis->expire($key, $interval);
        }
        return $requestCount;
    }
}