<?php
//代表数据库类,负责对数据库进行操作

class DBDirver{
	// 属性可以在不同的类中使用
	public $connetion;  //该属性代表数据库连接属性
	public $statement;  //该属性代表数据库查询(语句)

	public function __construct(){
		$drivers=array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		// 异常处理（捕捉）
		try {
			// 连接数据库
			$this->connetion=new PDO('mysql:host=localhost;port=3306;dbname=test','root','123456',$drivers);
		} catch (PDOException $e) {
		    echo '数据库连接出错，异常消息内容: ' . $e->getMessage(),'<br>';
		    exit;
		}
		echo '数据库连接成功','<br>';
	}

	//该方法代表查询数据库,让数据库执行查询语句
	// 查询结果保存在 $statement 对象里
	public function query($sql){
		try{
			$this->statement=$this->connetion->query($sql);
		}catch(PDOException $p){
			echo '查询错误代号: ' . $this->connetion->errorCode(),'<br>';
			echo '查询错误原因: ' . $this->connetion->errorInfo()[2],'<br>';
			exit;
		}

		//以下代码是在PDO错误处理方式是静默情况下采用的错误处理代码
		// if ($this->statement==false) {
		// 	echo '查询错误代号: ' . $this->connetion->errorCode(),'<br>';
		// 	echo '查询错误消息: ' . $this->connetion->errorInfo()[2],'<br>';
		// 	exit;
		// }
		// return $this->statement;
	}

	// 从数据库查询结果的第一种办法:
	// 从数据库查询结果中获取数据,从PDOStatement中获取一条记录
	// public function get_results(){
	// 	$statement->fetch();
	// }
	// // 从PDOStatement中获取多条记录
	// public function get_results_many(){
	// 	$statement->fetchAll();
	// }

	// 第二种办法：创建一个方法，根据标记的不同，返回不同的记录数
	// PDO::FETCH_ASSOC：返回一个索引为结果集列名的数组
	public function get_results_records($sql,$only=true,$fetch_style=PDO::FETCH_ASSOC){
			// 每次查询的结果都不一样，所以调用query函数
		$this->query($sql);
		if ($only==true) {
			return $this->statement->fetch($fetch_style);//返回一条记录
		} else {
			return $this->statement->fetchAll($fetch_style);//返回多条记录
		}
		
	}

	// 对数据库进行增、删、改操作
	public function exec($sql){
		try{
			// exec()删除受影响的行数。如果没有修改或者删除，则返回值是0。
			$n=$this->connetion->exec($sql);
		}catch(PDOException $p){
			echo '错误代号: ' . $this->connetion->errorCode(),'<br>';
			echo '错误原因: ' . $this->connetion->errorInfo()[2],'<br>';
			exit;
		}
		echo '操作成功！','<br>';
		echo '受影响的行数是：'.$n.'行。','<br>';

		//以下代码是在PDO错误处理方式是静默情况下采用的错误处理代码
		// 注意：该函数有可能会返回布尔类型数值FALSE——比如（因为SQL语句写错）数据库执行修改或者删除出错。由于有些非布尔类型值等同于FALSE，例如0，因此，函数返回值最好用===运算符来测试。
		// if ($n===false) {
		// 	echo '查询错误代号: ' . $this->connetion->errorCode(),'<br>';
		// 	echo '查询错误消息: ' . $this->connetion->errorInfo()[2],'<br>';
		// 	exit;
		// }else{
		// 	echo '操作成功！','<br>';
		// 	echo '受影响的行数是：'.$n.'行。','<br>';
		// }
	}

	// 返回最后插入行的ID或序列值
	public function lastInsertId(){
		$id=$this->connetion->lastInsertId();
		return $id;
	}

}


