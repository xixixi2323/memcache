<?php

// if(extension_loaded('memcached')){
//     $memc = new memcached();
//     }else{
//         $memc = new Memcache();
//     }
// $memc->connect('127.0.0.1',11211);
// $k='num';
//  if( $v= $memc->get($k) ){
//    if($v == 10)
//     $memc->flush();
//   else
//     $memc->increment($k);
//  }else{
//     // $memc->set($k,1,3600);
//     if(extension_loaded('memcached')){
//             $memc->set($k,1,3600);
//         }else{
//             $memc->set($k,1,MEMCACHE_COMPRESSED,3600);
//         }
//  }

$db = include './pdo.php';
$cache = include 'Cache.php';

 $k='num';
 if( $v= $cache->get($k) ){
   if($v == 10)
    $cache->flush_();
  else{
    $cache->incr($k);
    // echo $v;
  }

 }else{
    // $memc->set($k,1,3600);
    $cache->save($k,1);
    // echo $cache->get($k);
 }
 // echo $v;
 echo "<hr>";

$data = [];

$key = 'news_1';
// 判断一下缓存中是否存在数据 ，存在则调用缓存中的数据，不存在则读数据并且写入到缓存
if($cache->has($key)){
    echo '有缓存';
    // 读缓存数据
    $data = $cache->get($key);
    var_dump($data);
}else{
    echo '没有';
    // 读数据库中的数据
    $sql = "select * from area limit 10";
    $data = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    var_dump($data);
    // 写入到缓存
    $cache->save($key,$data);
}
echo '<hr>';

?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新闻列表</title>
</head>
<body>
    <ul>
        <?php foreach ($data as $key => $value): ?>
        <li><a href="name.php?key=<?php echo $key?>"><?php echo $value['name'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
