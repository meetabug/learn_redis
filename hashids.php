<?php
require 'vendor/autoload.php';

use Hashids\Hashids;

$hashids =new Hashids();
$id = $hashids->encode(1);
echo $id."<br/>" ; //jR
//可以使用decode()方法还原解码id，注意这里得到的是一个数组。
$numbers = $hashids->decode($id); //[1]
var_dump($numbers);echo "<br/>";

//你也可以加盐，或者说是设置一个密钥，与别的项目不一样，可以保证生成唯一的字符串。
$hashids = new Hashids('My Project');
$hashids->encode(1, 2, 3); // Z4UrtW

$hashids = new Hashids('My Other Project');
$hashids->encode(1, 2, 3); // gPUasb

//当然，你也可以将转换后的字符串的长度加长，比如下方代码设置了字符串为10位字符。
$hashids = new Hashids(); // no padding
$hashids->encode(1); // jR

$hashids = new Hashids('', 10); // pad to length 10
$hashids->encode(1); // VolejRejNm

//值得注意的是：
//Hashids解码时返回的是数组，哪怕是一个id数字最后也会返回数组。
//Hashids不能转换加密负数。
//Hashids不是安全库，不能将敏感信息作为编码。