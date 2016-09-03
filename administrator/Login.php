<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<title>Document</title>
	<style type="text/css">
	body{
		width: 600px;
		margin: 0 auto;
		background: #cde6c7;
	}
	/*整个界面只有宽度为600px*/
	</style>
</head>
<body>
<li  style="font-size: 40px;
        list-style-type:none;
        text-align: center;
        color: #006400;">UTOPIA</li>
        <!-- 显示论坛名字 -->
 <li  style="font-size: 40px;
        list-style-type:none;
        text-align: center;
        color: #006400;">管理员登录界面</li>
        <!-- 显示是管理员登录界面 -->
<form style="margin-top: 20%;" method="post" action="judge.php" class="w3-container">
<!-- 上边距为20% ，同时由judge.php来接受和处理表单程序-->
<label class="w3-label w3-text-blue"><b>UserName:</b></label>
<!-- 提示UserName -->
<input class="w3-input w3-border" name="username" maxlength = '13' type="text">
 <!-- 设置input 设置了maxlength 意思是最多可以输入13个字符 -->
<label class="w3-label w3-text-blue"><b>PassWord:</b></label>
<!-- 提示PassWord -->
<input class="w3-input w3-border" name="password" maxlength="16" minlength="6" type="password">
<!-- 设置input 设置了maxlenth，minlenth ，最多可以输入16个字符，至少输入6个字符 -->
<input type="submit" name="submit" class="w3-btn w3-blue" value="Login">
 <!-- 提交按钮。 -->
</form>
</body>
</html>