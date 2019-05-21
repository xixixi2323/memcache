<?php
$id = $_GET['key'];
echo $id;
$cache = include './cache.php';
if($cache->has('area'.$id)){
    $cache->incr('area'.$id);

}else{
    $cache->save('area'.$id,1);

}

echo '<hr>';
echo $cache->get('area'.$id);


 ?>