<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php 
	include '../conn/conn.php';
	// 吧连接数据库文件包含过来
	if(!empty($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password'])){
		// 如果点了提交按钮，同时用户名和密码不为空的话就执行下面的代码
		$username = $_POST['username'];
		// 吧用户名放在一个变量中
		$password = $_POST['password'];
		// 吧密码放在一个变量中
		if ($username == 'administrator' && $password == 'administrator') {
			// 如果用户名和密码都等于administrator的话就执行下面的代码
			session_start();
			// 开启session
			$_SESSION['sign'] = $username;
			// 吧用户名复制给$_SESSION['sign'];
			echo '<script type="text/javascript">
     		 document.location.href="show_card.php";
      		</script>';
      		// 同时跳转到显示帖子的界面
		}
		else{
			echo '<script type="text/javascript">
			 alert("管理员用户或密码错误，请你重新登录！");
     		 document.location.href="Login.php";
      		</script>';
      		// 如果不相等，就给用户提示，用户或者密码错误，请重新登录，然后返回到登录界面
		}
		
	}
	else{
		echo '<script type="text/javascript">
      alert("用户名或者密码不能为空，请你重新输入！");
      document.location.href="Login.php";
      </script>';
	}
	// 如果用户或者密码为空的话就提示用户返回到登录界面
	 ?>
	
</body>
</html>