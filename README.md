# yii2-redis-rate-limiter

## 

**Example code**

```php
use ziya\RedisRateLimiter\exceptions\LimitExceeded;
use ziya\RedisRateLimiter\Limiter;

$key = 'api_request_{user_id}'; //Unique key identifier
$count = 60; // Request count in given amount of time
$interval = 60; //Request interval time
$limiter = new Limiter($key,$count,$interval);
//Set connection is optional. By default it get connection from Yii::$app->redis
// $limiter->setConnection(Yii::$app->redis);

try {
    $limiter->limit();    
    //limit not exceeded
} catch (LimitExceeded $exception) {
   //limit exceeded
}
```
