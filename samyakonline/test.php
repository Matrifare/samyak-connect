<pre>
<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10/5/2018
 * Time: 7:17 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'lib/RedisLib.php';
$cache = new RedisLib();

if(empty($cache->getCacheData('samyak_data'))) {
    $cache->setCacheData('samyak_data', array("matri_id"=>"MF1202", "samyak_id"=>"SA1202"));
} else {
    print_r($cache->getCacheData('samyak_data'));echo "<br/>";
}
//$cache->deleteCacheData('samyak_data');
exit;

//Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server sucessfully";echo "<br/>";
//set the data in redis string
$array = ['545'=>1, '454'=>2, '445'=>3];
$array2 = ['545'=>$array, '454'=>2, '445'=>3];
   $redis->set("new-data", json_encode($array2));
   // Get the stored data and print it
   echo "Stored string in redis:: ";
print_r(json_decode($redis->get("tutorial-name"), TRUE));echo PHP_EOL;
print_r(json_decode($redis->get("tutorial-name1"), TRUE));echo PHP_EOL;
print_r(json_decode($redis->get("new-data"), TRUE));
?>