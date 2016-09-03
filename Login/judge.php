<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php 
    include '../conn/conn.php';
    // 把连接数据库的文件包含过来
    $username = $_POST['username'];
    // 把用户名赋值一个变量
    $password = $_POST['password'];
    // 把密码赋值给一个变量 
    $judge = 0;
    // 设置一个标记
    if (!empty($_POST['submit'])) {
      // 如果用户点了登录按钮，就执行以下代码
    $sql = "select * from `tb_register` ";
    // 查询注册表
    $sql = mysqli_query($conn,$sql);
    // 执行查询语句
  	while($object = mysqli_fetch_object($sql)){
 
  		if(($object -> UserName) == $username && ($object -> PassWord) == $password ){
  			$judge = 1;
  			break;
        // 如果用户名和密码都相等的话就跳出循环，并给这个标记赋值为1
  		}
  	}
  	if ($judge) {
      // 如果为1的话表示用户名和密码都正确
  		session_start();
      // 设置一个sessoin
  		$_SESSION['sign'] = $username;
      // 吧用户名的值赋值给session
  		mysqli_free_result($sql);
      // 关闭查询结果集
    	mysqli_close($conn);
      // 关闭连接
  		echo '<script type="text/javascript">
      document.location.href="../show_card/show_card.php";
      </script>';
      // 跳转到显示帖子的界面
  	}
  	else{
      // 如果不等于1，表示用户名或者密码有错。
  		mysqli_free_result($sql);
      // 同样关闭查询结果集
    	mysqli_close($conn);
      // 同样关闭连接
  		echo ' <script type="text/javascript">
		 alert("用户名或密码错误，请你重新登录！！！");
		</script>';
		echo '<script type="text/javascript">
			document.location.href="index.php";
			</script>';
      // 给用户提示密码或者用户名错误，然后跳转到登录界面
  	}
    }

	 ?>
</body>
</html>