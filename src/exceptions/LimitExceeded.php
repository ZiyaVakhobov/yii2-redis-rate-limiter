<?php

namespace ziya\RedisRateLimiter\exceptions;

use Throwable;

class LimitExceeded extends \Exception
{
    private $count;
    private $interval;

    /**
     * LimitExceeded constructor.
     * @param $count
     * @param $interval
     */
    public function __construct(int $count, int $interval)
    {
        parent::__construct("Limit of requests exceeded", 429);
        $this->count = $count;
        $this->interval = $interval;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

}