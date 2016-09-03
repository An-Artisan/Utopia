<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<meta name="keywords" content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!--webfonts-->
<link href='http://fonts.useso.com/css?family=PT+Sans:400,700,400italic,700italic|Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.useso.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="../css/w3.css">
<!--//webfonts-->
<link rel="stylesheet" type="text/css" href="../css/w3.css">
<script src="http://ajax.useso.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>

<script>$(document).ready(function(c) {
	$('.close').on('click', function(c){
		$('.login-form').fadeOut('slow', function(c){
	  		$('.login-form').remove();
		});
	});	  
});
</script>
<!--  <p style="text-align: right;font-size: 30px;" ><img style="opacity: 0.8;" onclick="window.location.href='../Register/register.php';" src="images/register.png"></p> -->

<ul class="w3-navbar w3-light-grey" style = 'float:right;margin-top: -10px;'>
  <li><a href="../administrator/Login.php" target="_blank" >管理员登录</a></li>
  <li><a href="../Register/register.php" target="_blank" >注册用户</a></li>
</ul>

 <!--SIGN UP-->
 <h1>Welcome To Utopia_BBS</h1>
<div class="login-form">
	
	<div class="avtar"> 
		<?php 
		session_start();
		// 启动session
    	if (!empty($_SESSION['picture'])) {
    		echo "<img style='width: 80px;height: 80px;' src='..\Register\upfile\\",$_SESSION['picture'],"'>";
    		// 如果picture存在，说明，注册的时候你选择了头像，就显示你上传的头像。
    	}
    	else{
    		echo "<img src='images/avtar.jpg'>";
    		// 否则就是不存在就显示系统自带的头像
    	}
    	?>
		 
		
		
	</div>
			<form action="judge.php" method="post">
					<input type="text" class="text" name="username" value="UserName" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Please Input Username';}" >
						<div>
						<!-- 默认的值是Please Input Username，点单击的时候就把默认值取消， -->
					<input type="password" value="Password" name="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
						<!-- 默认的值是password，点单击的时候就把默认值取消， -->

						</div>
					<input type="submit" name="submit" value="Login" >
			</form>
	
</div>
<!-- <div style="position: fixed;bottom: 0;text-align: center;">版权所有 ®2016.6.18 © 重庆师范大学-计算机信息与科学学院-计算机科学技术（职教师资）刘强！此论坛只供学习使用，请勿商用！</div>  -->
<div  style="width: 100%;position: fixed;bottom: 0;font-size: 20px;" class="w3-container w3-teal">
  <p style="text-align: center;">版权所有 ®2016.6.18 © 重庆师范大学-计算机信息与科学学院-计算机科学技术（职教师资）刘强！此论坛只供学习使用，请勿商用！</p>
</div>

</body>
</html>