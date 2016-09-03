<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<style type="text/css">
	.w3-myfont {
  			font-family: "Comic Sans MS", cursive, sans-serif;
		}
		/*设置整个页面的字体*/
	</style>
</head>
<body class="w3-container">
<!-- 内容居中 -->
<table class="w3-myfont w3-table w3-striped w3-bordered w3-border">
<!-- 设置字体，边线 -->
<form action="Card_Manage.php" method="post">
<!-- 设置一个表单，当前界面来接受 -->
<?php
	session_start();
	// 开启session
	if (!empty($_SESSION['sign'])) {
		// 如果$_SESSION['sign']存在的话就继续执行。
	include '../conn/conn.php';
	// 把连接数据库的文件包含过来
	 $rowsPerPage = 2;
    //定义每页的行数
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) AS count FROM `tb_publish` "));
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
$sql = "select * from `tb_publish` LIMIT ". ($curPage - 1) * $rowsPerPage . ",$rowsPerPage ";
// 查询语句，限制查询的记录
$sql = mysqli_query($conn,$sql);
// 执行查询语句
while ($object = mysqli_fetch_object($sql)) {
	// 取出来记录
?>
<thead >
<tr  class="w3-light-grey w3-hover-red">
  <th>UserName</th>
  <th>Title</th>
  <th>Time</th>
  <th>ID</th>
  <th>Reply</th>
  <th>Browse</th>
  <th>Delete_Card</th>
</tr>
<!-- 设置一个表头，显示发贴人的信息 -->
<tr name = 'tr' class="w3-hover-green">
<?php
echo  "<td>",$object -> username,"</td>";
echo  "<td>",$object -> title,"</td>";
echo  "<td>",$object -> time,"</td>";
echo  "<td>",$object -> ID,"</td>";
echo  "<td>",$object -> reply,"</td>";
echo  "<td>",$object -> browse,"</td>";
echo "<td><input class='w3-btn w3-brown' name = 'submit_title' type = 'submit' style = 'width:100px;' value = 'Delete' ></td>";
echo '</tr>';

?>
<!-- 把所有的帖子信息输出来，增加一个input按钮，删除用 -->
</thead>
<thead>
<tr class="w3-light-grey w3-hover-red">
  <th>Reply_UserName</th>
  <th>Reply_Content</th>
  <th>Reply_Time</th>
  <th>Reply_ID</th>
  <th>Reply_City</th>
  <th>Reply_Ip</th>
  <th>Delete_Reply</th>
</tr>
</thead>
<!-- 在增加一个表头，显示回帖人的信息 -->
<?php
$ID = $object -> ID;
// 把ID取出来

$sql_reply = "select * from `tb_reply` where `ID` = '$ID'";
// 以ID为条件去查询回复表中的记录
$sql_reply = mysqli_query($conn,$sql_reply);
// 执行查询语句
while ($object_reply = mysqli_fetch_object($sql_reply)) {
echo '<tr name = "tr_reply" class="w3-hover-green">';
echo  "<td>",$object_reply -> username,"</td>";
echo  "<td>",$object_reply -> content,"</td>";
echo  "<td>",$object_reply -> reply_time,"</td>";
echo  "<td>",$object_reply -> ID,"</td>";
echo  "<td>",$object_reply -> city_name,"</td>";
echo  "<td>",$object_reply -> reply_ip,"</td>";
echo "<td><input class='w3-btn w3-brown' name = 'submit_reply' type = 'submit' style = 'width:100px;' value = 'Delete' ></td>";
echo '</tr>';
// 以上把回复人的所有信息显示出来，增加了一个input按钮，用来删除这个用户信息
}

}
 ?>
 <input id="ID" name="ID" type="hidden"   >
 <!-- 增加一个隐藏域，用js作为中间变量吧值赋值给PHP后台 -->
</form>
</table>
<script type="text/javascript">
	var oTr = document.getElementsByName('tr');
	// 获取所有的tr
	var oID = document.getElementById('ID');
	// 获取隐藏域的ID
	for (var i = 0; i < oTr.length; i++) {
		// 循环所有的tr
			oTr[i].index = i;
			// 给tr添加一个新属性，index,然后复制
			oTr[i].onclick = function(){
				// 当单击delete按钮的时候把显示在屏幕上的ID值取出来
			var oId = oTr[this.index].getElementsByTagName('td');		
			// alert(oId[3].innerHTML);
			oID.value = oId[3].innerHTML;
			// 取出来赋值给隐藏域
		}
	}
	var oTr_reply = document.getElementsByName('tr_reply');
	// // 获取所有的name值为tr_reply
	for (var i = 0; i < oTr_reply.length; i++) {
		// 给tr_reply添加一个新属性，index,然后复制
			oTr_reply[i].index = i;
			// 当单击delete的时候吧显示在屏幕上的ID值取出来。
			oTr_reply[i].onclick = function(){
			var oId = oTr_reply[this.index].getElementsByTagName('td');		
			// alert(oId[0].innerHTML);
			oID.value = oId[2].innerHTML;
			// 取出来赋值给隐藏域

		}
	}
</script>
<?php 

 echo '<ul class="w3-pagination">';
   // 如果大于1的话就有下一页和首页
    if ($curPage > 1) {
        echo "<li><a class='w3-hover-sand w3-pale-blue ' href = 'Card_Manage.php?curPage=" . ($curPage - 1) . "'>&laquo;</a></li>";
         echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'Card_Manage.php?curPage=1'>首页</a></li>";
            }
     for ($i = 1; $i <= $pages; $i++) {//循环显示，每个链接指定curPage属性为其指向的页数就可以了
            echo "<li><a class = 'w3-light-grey w3-hover-aqua'  href='Card_Manage.php?curPage=",$i,"'>$i</a></li>","&nbsp;";
         }       
        //如果不是最后一页的话就有下一页和末页的标记。
        if ($curPage < $pages) {
            echo "<li><a class='w3-hover-sand w3-pale-blue' href='Card_Manage.php?curPage=" . ($curPage + 1) . "'>&raquo;</a></li>";
            echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'Card_Manage.php?curPage=$pages'>末页</a></li>";
            }
            // 显示所有的信息

            echo "<br><br><li><a class='w3-hover-sand w3-pale-blue' >当前第" . $curPage . "页" . "/" . "共" . $pages . "页" . "/" . "每页显示" . $rowsPerPage . "条" . "/" . "共" . $rows . "条记录" . "<br></a></li></ul>";
 // 如果点击了提交按钮才执行这段代码
if (!empty($_POST['submit_title'])) {
	$id = $_POST['ID'];
	// 吧隐藏域的值赋值给$id
	$sql = "delete from `tb_publish` where `ID` = '$id'";
	// 然后以id为条件来删除发帖表中的记录
	mysqli_query($conn,$sql);
	// 执行sql语句
	
	$sql = "delete from `tb_reply` where `ID` = '$id'";
	// 通知还要删除回复表中ID为$id的记录
	mysqli_query($conn,$sql);
	// 执行sql语句
	
	echo "<script>alert('删除帖子成功!');location.href='Card_Manage.php';</script>";
	// 给用户一个提示，已经删除成功了。
}
 // 如果点击了提交按钮才执行这段代码
if (!empty($_POST['submit_reply'])) {
	// 吧隐藏域的值赋值给$id
	$id = $_POST['ID'];
	// 然后以id为条件来删除发帖表中的记录
	$sql = "delete from `tb_reply` where `reply_time` = '$id'";
	// 执行sql语句
	mysqli_query($conn,$sql);
	
	echo "<script>alert('删除回复成功!');location.href='Card_Manage.php';</script>";
	
	// 给用户一个提示，删除回复信息成功！
}

}
else{
	echo "<script>alert('你没有权限执行此操作，请您登录！');location.href='../Login/index.php';</script>";
}
// 如果session['sign']不存在的话，就提示说没有权限，然后返回到登录界面

 ?>


</body>
</html>