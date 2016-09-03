<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
</head>
<body>
<table class="w3-table w3-striped w3-bordered w3-border">
<thead>
<tr class="w3-light-grey w3-hover-red">
  <th>头像</th>
  <th>用户名</th>
  <th>密码</th>
  <th>性别</th>
  <th>E-mail</th>
  <th>注册时间</th>
</tr>
</thead>
<tr class="w3-hover-black">

	<?php 
	include '../conn/conn.php';
	session_start();
	$username = $_SESSION['sign'];
	// $username = $_GET['username'];
	$sql = "select * from `tb_register` where `UserName` = '$username'";
	$sql = mysqli_query($conn,$sql);
	$object = mysqli_fetch_object($sql);
  	echo"<td><img  style='width:60px;height:60px;' src='../Register/upfile/",$object -> Head_filename,"'></td>";
  	echo "<td>",$username,"</td>";
	echo "<td>",$object -> PassWord,"</td>";
	echo "<td>",$object -> Sex,"</td>";
	echo "<td>",$object -> E_mail,"</td>";
	echo "<td>",$object -> Register_time,"</td>";
	$password = $object -> PassWord;
	$sex = $object -> Sex;
	$e_mail = $object -> E_mail;
	$head_name = $object -> Head_filename;
	mysqli_free_result($sql);
    // 关闭查询结果集
	 ?>
</tr>
</table>

<form class="w3-container" enctype='multipart/form-data'  action="personal_data.php" method="post" >
<label class="w3-label w3-text-blue"><b>修改个人信息</b></label>
<br>
<br>
<br>
<br>
<label class="w3-label w3-text-blue"><b>新密码</b></label>
<input class="w3-input w3-border" name="password" type="password">
 
<label class="w3-label w3-text-blue"><b>性别</b></label>
<input class="w3-radio" style="width: 45px;height: 20px;" type="radio" name="sex" value="男" /> 男
<input class="w3-radio" style="width: 45px; height: 20px;" type="radio" name="sex" value="女" /> 女
<br>
<label class="w3-label w3-text-blue"><b>E-mail</b></label>
<input class="w3-input w3-border" name="e_mail" type="text">
<label class="w3-label w3-text-blue"><b>上传头像</b></label>
<input class="w3-input" name="zp" type="file" >
<input class="w3-btn w3-blue" name="submit" type="submit" value="修改">
 
</form>
<?php 
if (!empty($_POST['submit'])) {
	if (!empty($_POST['password'])) {
		$password = $_POST['password'];
	}

	if (!empty($_POST['sex'])) {
    	$sex = $_POST['sex'];
    }
    if (!empty($_POST['e_mail'])) {
    	$e_mail = $_POST['e_mail'];
    }
	if (!empty($_FILES['zp']['tmp_name'])) {
    	// 如果上传了图片
    if(is_file('../Register/upfile/'.$head_name) && ($head_name != 'default.jpg') && ($head_name != 'administrator.jpg'))  //判断是否存在该文件，并且该文件名不是默认头像和管理员头像                           
  {
    unlink('../Register/upfile/'.$head_name);  //删除文件
   }
     $date = date('Y-m-dHis',time());
     // 把当前上传图片的时间精确到秒作为文件名重新赋值给上传文件作为它的新的文件名
	$uptype = explode(".", $_FILES["zp"]["name"]);
	// 以.来截取文件的后缀名
    @$head_name = $date.".".$uptype[1];
    // 然后把当前时间加上后缀名就是该图片的新名称。
	$_FILES["zp"]["name"] = $head_name;
	// 给上传的头像重新命名
	if (!is_dir("../Register/upfile")) {//判断服务器中在网页文件目录下是否存在指定文件夹upfile
			mkdir("../Register/upfile");
			//如果不存在，则创建文件夹
		}
	$path = "../Register/upfile/".$_FILES["zp"]["name"];
		//定义上传文件存储位置
		
	move_uploaded_file($_FILES["zp"]["tmp_name"], $path);
	// 移动文件到自己建的文件夹下

}
$sql = "UPDATE `tb_register` SET  `PassWord` = '$password',`Sex` = '$sex' ,`E_mail` = '$e_mail',`Head_filename` = '$head_name'   WHERE `UserName` = '$username'";
$sql = mysqli_query($conn,$sql);
mysqli_close($conn);
echo "<script>alert('修改成功!');location.href='personal_data.php';</script>";
}

 ?>
</body>
</html>