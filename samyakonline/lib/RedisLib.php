<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10/5/2018
 * Time: 8:13 PM
 */

class RedisLib {
    public $redis;

    //Connect to Redis
    function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    // Set Cache Data
    function setCacheData($key, $value) {
        $this->redis->set($key, json_encode($value));
        return false;
    }

    // Get Cache Data
    function getCacheData($key, $array = TRUE) {
        if($array) {
            return json_decode($this->redis->get($key), TRUE);
        } else {
            return json_decode($this->redis->get($key));
        }
    }

    //Delete Cache Data
    function deleteCacheData($key) {
        $this->redis->delete($key);
    }

    //Get All Keys Data
    function getAllKeys(){
        return $this->redis->keys("*");
    }
}