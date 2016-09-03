<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<style type="text/css">
	.w3-myfont {
  			font-family: "Comic Sans MS", cursive, sans-serif;
		}
    /*设置显示的字体*/
	</style>
</head>
<body class="w3-container">
<table class="w3-table w3-myfont w3-striped w3-bordered w3-border">
<form action="User_Manage.php" method="post">
<thead>
<tr class="w3-light-grey w3-hover-blue">
<!-- 显示表头文件 -->
  <th>Head</th>
  <th>UserName</th>
  <th>PassWord</th>
  <th>Sex</th>
  <th>E-mail</th>
  <th>Register_time</th>
  <th>Delete_User</th>
</tr>
</thead>
	<?php
	session_start();
  // 开启session
	if (!empty($_SESSION['sign'])) {
		// 如果用户标识存在的时候才继续执行以下的代码
	include '../conn/conn.php';
  // 把连接数据库的文件包含过来
	 $rowsPerPage = 7;
    //定义每页的行数
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) AS count FROM `tb_register` "));
    //查询表中的总记录数以别名方式保存在row中
    $rows = $row['count'];
    //得到表中总记录数，转换字符串为数值型！
    $pages = ceil($rows / $rowsPerPage);
    //计算出页数
    $curPage = 1;
    //当前要显示第几页，默认显示第1页 
    if (isset($_GET['curPage'])){
    //假如用户提交了指定的页数
     $curPage = $_GET['curPage'];
    // 就将欲显示的页数设定为用户定的值
    }
    $sql = "select * from `tb_register` LIMIT ". ($curPage - 1) * $rowsPerPage . ",$rowsPerPage   ";
    // 查询limit限制的记录
	$sql = mysqli_query($conn,$sql);
  // 执行查询语句
	while ($object = mysqli_fetch_object($sql)) {
    // 找到查询结果集并输入在屏幕上
		
		?>

<?php
echo '<tr class="w3-hover-green">';
  echo"<td><img  style='width:60px;height:60px;' src='../Register/upfile/",$object -> Head_filename,"'></td>";
  echo "<td>",$object -> UserName,"</td>";
  echo "<td>",$object -> PassWord,"</td>";
  echo "<td>",$object -> Sex,"</td>";
  echo "<td>",$object -> E_mail,"</td>";
  echo "<td>",$object -> Register_time,"</td>";
  echo "<td><input class='w3-btn w3-brown' name = 'submit' type = 'submit' style = 'width:100px;' value = 'Delete' ></td>";
echo "</tr>";
	}
	// 设置一个input提交按钮，如果点击提交后就删除该用户，并且删除该用户发的帖子信息和回复信息
// 以上是输出所有的查询结果集信息
mysqli_free_result($sql);
    // 关闭查询结果集
?>
<input id="UserName" name="UserName" type="hidden"   >
<!-- 设置一个隐藏域 -->
</form>
</table>
<script type="text/javascript">
var aBtn = document.getElementsByTagName('input');
// 找到所有的input
var aTr = document.getElementsByTagName('tr');
// 找到所有的tr
var oHid = document.getElementById('UserName');
// 找到隐藏域
for (var i = 0; i < aBtn.length; i++) {
  // 给所有的删除按钮赋值一个新属性index
		aBtn[i].index = i;
    // 并给这个新属性赋值
		aBtn[i].onclick = function(){
      // 如果单击删除按钮
			var aTd = aTr[this.index+1].getElementsByTagName('td');
       // 就把tr下的td获取到
			oHid.value = aTd[1].innerHTML;
      // 吧tr的第一行也就是用户名赋值给隐藏域
		}
	}	
</script>
<?php 
 echo '<ul class="w3-pagination">';
   // 如果不是第一页的话就有上一页和首页的标记。
    if ($curPage > 1) {
        echo "<li><a class='w3-hover-sand w3-pale-blue ' href = 'User_Manage.php?curPage=" . ($curPage - 1) . "'>&laquo;</a></li>";
         echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'User_Manage.php?curPage=1'>首页</a></li>";
            }
     for ($i = 1; $i <= $pages; $i++) {//循环显示，每个链接指定curPage属性为其指向的页数就可以了
            echo "<li><a class = 'w3-light-grey w3-hover-aqua'  href='User_Manage.php?curPage=",$i,"'>$i</a></li>","&nbsp;";
         }       
        //如果不是第一页的话就有上一页和首页的标记。
        if ($curPage < $pages) {
            echo "<li><a class='w3-hover-sand w3-pale-blue' href='User_Manage.php?curPage=" . ($curPage + 1) . "'>&raquo;</a></li>";
            echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'User_Manage.php?curPage=$pages'>末页</a></li>";
            }
            // 显示所有的查询信息等!

            echo "<br><br><li><a class='w3-hover-sand w3-pale-blue' >当前第" . $curPage . "页" . "/" . "共" . $pages . "页" . "/" . "每页显示" . $rowsPerPage . "条" . "/" . "共" . $rows . "条记录" . "<br></a></li></ul>";
	if (!empty($_POST['submit'])) {
    // 如果单击了删除按钮
	$username =  $_POST['UserName'];
  // 吧隐藏域的值赋值给一个变量
  $head = "select * from `tb_register` where `UserName` = '$username'";
  $head = mysqli_query($conn,$head);
  $head = mysqli_fetch_object($head);
  $head_name = $head -> Head_filename;
  if(is_file('../Register/upfile/'.$head_name) && ($head_name != 'default.jpg') && ($head_name != 'administrator.jpg'))  //判断是否存在该文件，并且该文件名不是默认头像和管理员头像                           
  {
    unlink('../Register/upfile/'.$head_name);  //删除文件
   }
	$sql = "delete from `tb_register` where `UserName` = '$username'";
  // 删除当前单击的那个一个用户
	mysqli_query($conn,$sql);
  // 执行查询语句
	$sql = "delete from `tb_publish` where `username` = '$username'";
  // 并且删除该用户发的帖子
	mysqli_query($conn,$sql);
  // 执行查询语句
	$sql = "delete from `tb_reply` where `username` = '$username'";
  // 并且删除该用户回复的帖子
	mysqli_query($conn,$sql);
  // 执行查询语句
	mysqli_close($conn);
  // 关闭查询连接
	echo "<script>alert('删除用户成功！');location.href='User_Manage.php';</script>";
  // 并且提示用户删除成功，并且刷新该界面
}

}
else{
	echo "<script>alert('你没有权限执行此操作，请您登录！');location.href='../Login/index.php';</script>";
}
// 如果用户表示不存在，就代表没有登录，提示用户没有权限执行此操作。跳转到登录界面
 ?>


	 
</body>
</html>