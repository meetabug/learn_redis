<?php
//实例化redis对象
 $redis = new Redis();
 //连接redis
 $redis->connect('127.0.0.1',6379);
 //查看服务是否运行
 echo "Server is running: ".$redis->ping();
//验证密码 ，返回【true | false】
 $redis->auth('password');
 //选择redis库, 0~15 共16个库
 $redis->select(0);
 //设置失效时间[true | false]
 $redis->expire('key',10);
 //把当前库中的key移动到15库中[0|1]
 $redis->move('key',15);
 //释放资源
 $redis->close();
//String字符串
$redis->set('key', 1);  //设置key=aa value=1 [true]
$redis->mset($arr);  //设置一个或多个键值[true]
$redis->setnx('key', 'value');  //key=value, key存在返回false[|true]
$redis->get('key');  //获取key [value]
$redis->mget($arr);  //(string|arr), 返回所查询键的值
$redis->del($key_arr);  //(string|arr)删除key，支持数组批量删除【返回删除个数】
$redis->delete($key_str, $key2, $key3);  //删除keys, [del_num]
$redis->getset('old_key', 'new_value');  //先获得key的值，然后重新赋值, [old_value | false]

$redis->strlen('key');  //获取当前key的长度
$redis->append('key', 'string');  //把string追加到key现有的value中[追加后的个数]
$redis->incr('key');  //自增1，如不存在key, 赋值为1(只对整数有效, 存储以10进制64位，redis中为str)[new_num | false]
$redis->incrby('key', $num);  //自增$num, 不存在为赋值, 值需为整数[new_num | false]
$redis->decr('key');  //自减1，[new_num | false]
$redis->decrby('key', $num);  //自减$num，[ new_num | false]
$redis->setex('key', 10, 'value');  //key=value，有效期为10秒[true]

//List列表
$redis->llen('key');  //返回列表key的长度, 不存在key返回0， [ len | 0]
$redis->lpush('key', 'value');  //增，只能将一个值value插入到列表key的表头(左侧)，不存在就创建 [列表的长度 |false]
$redis->rpush('key', 'value');  //增，只能将一个值value插入到列表key的表尾(右侧) [列表的长度 |false]
$redis->lInsert('key',  Redis::AFTER,  'value',  'new_value');  //增，将值value插入到列表key当中，位于值value之前或之后。[new_len | false]
$redis->lpushx('key', 'value');  //增，只能将一个值value插入到列表key的表头，不存在不创建 [列表的长度 |false]
$redis->rpushx('key', 'value');  //增，只能将一个值value插入到列表key的表尾，不存在不创建 [列表的长度 |false]
$redis->lpop('key');  //删，移除并返回列表key的头元素, [被删元素 | false]
$redis->rpop('key');  //删，移除并返回列表key的尾元素, [被删元素 | false]
$redis->lrem('key', 'value', 0);  //删，根据参数count的值，移除列表中与参数value相等的元素count=(0|-n表头向尾|+n表尾向头移除n个value)  [被移除的数量 | 0]
$redis->ltrim('key', start, end);  //删，列表修剪，保留(start, end)之间的值 [true|false]
$redis->lset('key', index, 'new_v');  //改，从表头数，将列表key下标为第index的元素的值为new_v,  [true | false]
$redis->lindex('key', index);  //查，返回列表key中，下标为index的元素[value|false]
$redis->lrange('key', 0, -1);  //查，(start, stop|0, -1)返回列表key中指定区间内的元素，区间以偏移量start和stop指定。[array|false]