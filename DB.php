<?php
include 'spl_autoload.php';

// 创建DBDirver对象，表示连接数据库
$db=new DBDirver();
$sql = 'SELECT * FROM users';
// $db->query($sql);

// $db->get_results_records($sql,false);获取的是多条数据
$r=$db->get_results_records($sql,false,PDO::FETCH_ASSOC);//获取的是一条数据,因为第2个参数没有写，而他的默认值是true，

// var_dump($r);
echo '名字：',$r[1]['name'],'<hr>';
// echo '密码：',$r['password'],'<hr>';

// $sql='delete from users where name="我是杨政然"';
// $db->exec($sql);
// echo '<hr>';
// exit;

// $name=$_POST['name'];
$sql='insert into users (name,password,intro) values("我是杨政然","123","123")';
$db->exec($sql);
$id=$db->lastInsertId();
echo '最后插入行的ID:'.$id,'<br>';
// 插入成功后显示出来
$sql='select * from users where id="'.$id.'"';
$r=$db->get_results_records($sql);
echo '欢迎您：',$r['name'],'<br>';
// var_dump($r);
