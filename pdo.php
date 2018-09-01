<?php
$dbhost = '127.0.0.1';//服务器

$dbport = 3306;//端口

$dbname = 'pdotest';//数据库名称

$dbuser = 'root';//用户名

$dbpass = '123456';//密码

try{
    $db = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$dbname,$dbuser,$dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//设置错误模式
    $db->query('SET NAMES utf8;');
}catch(PDOException $e){
    echo '{"result":"failed","msg":"连接数据库失败!"}';
    exit;
}
//PDO::setAttribute() 用于设置属性，如上面的代码中就设置了使用异常模式处理错误。


// 查询
//如果不使用预处理语句，可以直接使用query()和exec()方法执行sql语句。
//查询
$sql = "SELECT id,content,user_id FROM `comment` WHERE post_id = 2 ORDER BY id DESC ";
$db->query($sql);
//更新
$sql = "UPDATE `comment` SET content='second..' WHERE id = 5 ";
$db->exec($sql);

//而实际开发中我们最常用的是预处理语句，简单的说预处理语句预先将sql命令分析一次，可以多次执行，提高了处理效率，
//而且能有效防止SQL注入。在执行单个查询时快于直接使用query() 或exec() 的方法，速度快且安全，所以强烈推荐使用预处理语句。

//使用预处理语句处理时配套的方法是prepare() 和execute() 。
$sql = "SELECT id,content,user_id FROM `comment` WHERE post_id=? ORDER BY id DESC";
$stmt = $db->prepare($sql);
$post_id = 2;
$stmt->bindParam(1,$post_id,PDO::PARAM_INT);
$stmt->execute();
$row=$stmt->fetch();
// 我们在sql语句中使用问号(?) 参数作为占位符，使用bindParam() 可以设置绑定参数值。

// 如果有很多参数需要传递，可以这样写
$sql = "SELECT id,content,user_id FROM `comment` WHERE post_id=:post_id ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':post_id' => 2
]);
$row = $stmt->fetch();
//在execute() 方法中加入参数占位符数组，不使用 ? 占位符可能更直观点。
//fetch() 返回查询结果中的一行数据，数据以数组形式返回，该方法可以带参数，其中参数默认为 PDO::FETCH_BOTH，
//即返回一个索引为结果集列名和以0开始的列号的数组，而常用的参数PDO::FETCH_ASSOC则返回一个索引为结果集列名的数组。
//fetchAll() 可以获取结果集中的所有行，并赋给返回的二维数组。和fetch() 一样也可以带参数。


//插入
// 最常用的插入数据表的写法，如果有自增长id（一般必须有），使用lastInsertId() 可以获取到插入成功后的id。
$sql = "INSERT INTO `mycomments` (post_id,content,user_id,created_at) VALUES (:post_id, :content, :user_id, :created_at)";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':post_id' => 2,
    ':content' => 'Hello，啦啦啦',
    ':user_id' => 21,
    ':created_at' => date('Y-m-d H:i:s'),
]);
$lastid = $db->lastInsertId(); //返回插入成功后的id

//更新
//使用预处理更新数据，rowCount()返回影响行数，大于0即表示执行成功的记录数。
$sql = "UPDATE `mycomments` SET content=:content WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':content' => '我的天啊',
    ':id' => 6
]);
echo $stmt->rowCount();//1, 影响行数

//删除
// 对于只有一个参数需要绑定的，可以使用问号 ? 占位符。删除后同样使用rowCount() 返回影响行数，大于0表示执行成功。
$sql = "DELETE FROM `mycomments`  WHERE id=?";
$stmt = $db->prepare($sql);
$stmt->execute([6]);
echo $stmt->rowCount();//1

// 事务
//事务是确保数据库一致的机制，是一个或一系列的查询，作为一个单元的一组有序的数据库操作。
//如果组中的所有SQL语句都操作成功，则认为事务成功，事务则被提交。
//如果在事务的组中只有一个环节操作失败，事务也不成功，则整个事务将被回滚，该事务中所有操作都被取消。
//事务在开发中也经常用到，因为很多业务过程都包括多个步骤，如果任何一个步骤失败，则所有步骤都不应发生。
//值得注意的是，如果要用到事务处理功能，你的MySQL应该使用InnoDB引擎或者其他支持事务的引擎，切不可以使用MyISAM引擎。
try {
    $db->beginTransaction(); //启动事务
    $sql1 = "INSERT INTO `mycomments` VALUES (NULL,'1','wahaha','10','2018-07-25 12:12:01')";
    $sql2 = "UPDATE `mycomments` SET content='second...' WHERE sid=2";
    $sql3 = "INSERT INTO `mycomments` VALUES (NULL,'3','wahaha','30','2018-07-25 12:12:03')";

    $db->exec($sql1);
    $db->exec($sql2);
    $db->exec($sql3);

    $db->commit(); //提交事务
} catch (Exception $e) {
    $db->rollBack(); //回滚事务
}