<?php

class Cache {

    private $mem = null;

    public function __construct(string $host,int $port){
        $this->connect($host,$port);
    }

    // 返回值的类型 提升性能
    public function save(string $key,$value,int $expire=3600):void {
        if(extension_loaded('Memcached')){
            $this->mem->set($key,$value,$expire);
        }else{
            $this->mem->set($key,$value,MEMCACHE_COMPRESSED,$expire);
        }
        return;
    }

    // 获取
    public function get(string $key,string $default='0') {
        return $this->mem->get($key) ? $this->mem->get($key) : $default;
    }

    // 获取
    public function has(string $key) {
        return $this->mem->get($key) ? true : false;
    }

    // 删除
    public function del(string $key):void{
        $this->mem->delete($key);
        return;
    }



    // 连接memcache
    private function connect(string $host,int $port){
        if(extension_loaded('Memcached')){
            $mem = new Memcached();
        }else{
            $mem = new Memcache();
        }
        $mem->addServer($host,$port);
        $this->mem = $mem;
    }
    public function incr(string $key){
        $this->mem->increment($key);
    }
    public function flush_(){
          $this->mem->flush();
    }
}

return new Cache('127.0.0.1',11211);



 ?>