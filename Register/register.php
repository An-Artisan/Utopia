<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<style type="text/css">
	body{
    	background-image: url(bgp.jpg);
    	background-size: cover;
    }
    /*设置注册界面的背景图*/
    </style>
	
	
</head>
<body>
	<p style="font-size: 60px;
 		text-align: center;
 		color: #006400;">UTOPIA</p>

	<!-- 标题 -->
	<div style="width: 400px;margin: 0 auto;">
	<table class="w3-table w3-centered">
	<form action="register.php" class="w3-form w3-centered" enctype="multipart/form-data" method="post">
	    <label class="w3-label" >用户名称:</label>
		<input class="w3-input" type="text" name="username"  value="用户名" onclick="this.value = '';focus();">
		<!-- 鼠标移入清空原先提示语，同时获取焦点 -->
		<br>
		
	
	    <label class="w3-label">密码:</label>
	    <span id="pass">
		<input class="w3-input" id="pw" type="password" name="password" value="password" onclick="this.value = '';focus();"  >
		<!-- 鼠标移入清空原先提示语，同时获取焦点 -->

		</span>
	
		

	    <label class="w3-label">确认密码:</label>
		<span id="pass_one">
		<input class="w3-input" id="pws" type="password" name="confirm_password" value="password" onclick="this.value = '';focus();" >
		
		<!-- 鼠标移入清空原先提示语，同时获取焦点 -->

		</span> 
		
		
		<br>
		<label class="w3-label">E_Mail:</label>
		<input class="w3-input" type="text" name="e_mail" onclick="this.value = '';focus();" value="e_mail  ">

		<label class="w3-label">填写有效邮箱！</label>
		<br><br>
		<label class="w3-label">性别:</label>
		<input class="w3-radio" style="width: 45px;height: 20px;" type="radio" name="sex" value="男" /> 男
			
		<input class="w3-radio" style="width: 45px; height: 20px;" type="radio" name="sex" value="女" /> 女
		
		
		<br>		<br> 
		<label class="w3-label">上传头像:</label><input class="w3-input" name="zp" type="file" >
		
		<br>
		<input    style="width: 150px;" type="image" src="submit.jpg" value="submit" name="submit" >
		<!-- 图片域提交按钮 -->
	</form>
	</table>
	</div>
	<?php 
	include '../conn/conn.php';
	// 连接数据库包含过来
	if (!empty($_POST['submit'])) {
		// 单击注册按钮就执行以下代码
    $username = $_POST['username'];
    // 获取用户名
    $password = $_POST['password'];
    // 获取密码
    $e_mail = $_POST['e_mail'];
    // 获取邮箱
    if (!empty($_POST['sex'])) {
    	$sex = $_POST['sex'];
    }
    else{
    	$sex = '未知性别';
    }
    // 获取性别
    $confirm_password = $_POST['confirm_password'];
    // 获取确定密码
    // $sign = $username;
    $mark = 1;
    // 标记为1表示没有人注册过此用户名
   
    if (!empty($_FILES['zp']['tmp_name'])) {
    	// 如果上传了图片
     $date = date('Y-m-dHis',time());
     // 把当前上传图片的时间精确到秒作为文件名重新赋值给上传文件作为它的新的文件名
	$uptype = explode(".", $_FILES["zp"]["name"]);
	// 以.来截取文件的后缀名
    @$newname = $date.".".$uptype[1];
    // 然后把当前时间加上后缀名就是该图片的新名称。
	$_FILES["zp"]["name"] = $newname;
	// 给上传的头像重新命名
    	session_start();
    	// 开启一个Session
		$_SESSION['picture'] = $newname;
		// 吧新名字赋值给session，用来在登录界面显示刚刚上传的图片

	
	if (!is_dir("./upfile")) {//判断服务器中在网页文件目录下是否存在指定文件夹upfile
			mkdir("./upfile");
			//如果不存在，则创建文件夹
		}
	$path = "upfile/".$_FILES["zp"]["name"];
		//定义上传文件存储位置
		
	move_uploaded_file($_FILES["zp"]["tmp_name"], $path);
	// 移动文件到自己建的文件夹下
}
else{
	$newname = 'default.jpg';
	// 如果没有上传文件，就用默认头像
}
    $sql = "select * from `tb_register`"; 
    // sql语句
    $result =  mysqli_query($conn,$sql);
    // 执行sql语句
    while($object = mysqli_fetch_object($result)){
             if (($object -> UserName) == $username) {
             	  $mark= 0;
             }
    }
    // 判断表里面有没有用户输入的用户名，如果有的话就表示已经有人注册过了，吧mark赋值0
    if($mark){
    	// 如果为真，表示没人注册，执行下面语句
    	if ($password == $confirm_password && strlen($password) > 6 && $username!='') {
    		// 如果两次密码相等并且密码长度大于6位就把用户信息写入表中
    	$sql = "insert into `tb_register` (`UserName`,`PassWord`,`Sex`,`E_mail`,`Register_time`,`Head_filename`) values ('$username','$password','$sex','e_mail',now(),'$newname')";
    	// sql语句
    	mysqli_query($conn,$sql);
    	// 执行sql语句
    	mysqli_free_result($result);
    	// 关闭查询结果集
    	mysqli_close($conn);
    	// 关闭连接
    	echo ' <script type="text/javascript">
			alert("注册成功！！！");
		</script>';
		// 并且提示用户注册成功
		echo '<script type="text/javascript">
			document.location.href="../Login/index.php";
			</script>';
		}
		// 同时跳转到用户登录界面
		else if($password != $confirm_password ){
			// 如果两次密码不相等，就提示用户密码不相等，重新输入
			mysqli_free_result($result);
    		// 关闭查询结果集
    		mysqli_close($conn);
    		// 关闭连接		
			echo ' <script type="text/javascript">
			alert("两次密码不相等，请重新输入！");
		</script>';
		}
		else if (strlen($password) < 7) {
			// 如果密码相等，表示密码小于6位数，这是提示用户密码不能少于6位
			mysqli_free_result($result); 
			mysqli_close($conn);
			echo ' <script type="text/javascript">
			alert("密码不能少于6位！");
		</script>';
		}
		else{
			mysqli_free_result($result);
			mysqli_close($conn);
			echo ' <script type="text/javascript">
			alert("用户名不能为空！");
		</script>';
		}

    }
    else{
    	// 如果mark为0的时候，表示已经有人注册过该用户名，提示用户重新注册！
    	mysqli_free_result($result);
		mysqli_close($conn);
    	echo ' <script type="text/javascript">
			alert("该用户已经存在，请您重新注册！！！");
		</script>';

    }
}
	 ?>
</body>
</html>