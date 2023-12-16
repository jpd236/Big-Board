<?php
use Predis\Client;

class Cache {
    public $redis;
    public $default_max_age;

    public function __construct() {
        $redis_url = getenv('REDIS_URL');
        if ($redis_url !== false) {
            $this->redis = new Predis\Client($redis_url);
        } else {
            error_log("REDIS_URL not defined; cache disabled");
        }
        $this->default_max_age = getenv("MAX_CACHE_AGE");
    }    

    public function add($key, $value) {
        if (is_null($this->redis)) {
            return;
        }

        $val = [time(), $value];
        $json_blob = json_encode($val);
        $this->redis->set($key, $json_blob);
    }

    public function existsNoOlderThan($key, $max_age) {
        if (is_null($this->redis)) {
            return false;
        }
        if ($max_age < 0) {
            $max_age=$this->default_max_age;
        }

        $now = time();
        if ($this->redis->exists($key)) {
            $json_blob = $this->redis->get($key);
            $val = json_decode($json_blob, true);
            $age = $now - $val[0];
            if ($age < $max_age) {
                return true;
            }
        }
        return false;
    }

    public function get($key, $callable, $max_age=-1) {
        if (is_null($this->redis)) {
            return $callable();
        }

        if ($max_age < 0) {
            $max_age=$this->default_max_age;
        }
        

        if ($this->existsNoOlderThan($key, $max_age)) {
            $json_blob = $this->redis->get($key);
            $val = json_decode($json_blob, true);
            //error_log("cache hit for $key");
            return $val[1];
        }

        //error_log("cache missed for $key");
        $new_val = $callable();
        $this->add($key, $new_val);
        return $new_val;
    }
}
