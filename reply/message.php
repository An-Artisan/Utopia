<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <style type="text/css">
  body{
    background: #f2eada;
  }
  /*设置背景颜色*/
  </style>
</head>
<body>
<table class="w3-table w3-striped w3-bordered w3-border">
<!-- 设置一个table表格 -->
<form action="message.php" method="post">
<!-- 设置一个表单程序，My_card.php来接受和处理表单 -->
<thead>
<tr class="w3-light-grey w3-hover-red">
<!-- 表头信息 -->
  <th>UserName</th>
  <th>Title</th>
  <th>Time</th>
  <th>Reply</th>
  <th>Browse_Times</th>
  <th>Card_ID</th>
  <th>Browse_Card</th>
</tr>
</thead>

<?php 
	session_start();
  // 开启session
	if (!empty($_SESSION['sign'])) {
	// 如果用户标记存在的话就继续执行下面的代码
	include '../conn/conn.php';
  // 吧数据库连接文件包含过来
	// echo $_SESSION['sign'];
	$username = $_SESSION['sign'];
  // 吧用户标识赋值给一个变量
	$rowsPerPage = 7;
    //定义每页的行数
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) AS count FROM `tb_publish` WHERE `username` = '$username' "));
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
	$sql = "select * from `tb_publish` where `username` = '$username' and `message` <> 0  LIMIT ". ($curPage - 1) * $rowsPerPage . ",$rowsPerPage  ";
  // 查询用户名为当前登录用户的帖子
	$sql = mysqli_query($conn,$sql);
  // 执行sql语句
	while ( $object = mysqli_fetch_object($sql)) {
	echo '<tr class="w3-hover-blue">';
  	echo "<td>",$object -> username,"</td>";
  	echo "<td>",$object -> title,"</td>";
  	echo "<td>",$object -> time,"</td>";
  	echo "<td>",$object -> reply,"</td>";
  	echo "<td>",$object -> browse,"</td>";
  	echo "<td>",$object -> ID,"</td>";
  	echo "<td><input class='w3-btn w3-brown' name = 'submit' type = 'submit' style = 'width:100px;' value = 'Browse' ></td>";
  	echo '</tr>';
	}
// 吧帖子信息全部输出在屏幕上
  mysqli_free_result($sql);
    // 关闭查询结果集
$sql = "update `tb_publish` set `message` = 0 where `username` = '$username'";
mysqli_query($conn,$sql);
// 然后把新消息清空
   ?>
<input id="ID" name="ID" type="hidden"   >
<!-- 设置一个隐藏域 -->
</form>
</table>
<script type="text/javascript">
var aBtn = document.getElementsByTagName('input');
// 获取所有的input
var aTr = document.getElementsByTagName('tr');
// 获取所有的tr
var oHid = document.getElementById('ID');
// 获取隐藏域的ID
for (var i = 0; i < aBtn.length; i++) {
  // 给每一个提交按钮赋值一个新属性为index
		aBtn[i].index = i;
    // 当点击提交按钮时执行下面的语句
		aBtn[i].onclick = function(){
			var aTd = aTr[this.index+1].getElementsByTagName('td');
      // 获取当面TR下面的Td
			// alert(aTd[5].innerHTML); 
			oHid.value = aTd[5].innerHTML;
      // 吧第五个的值获取到也就是ID赋值给隐藏域
		}
	}	
</script>
<?php 
echo '<ul class="w3-pagination">';
   // 如果不是第一页的话就有上一页和首页的标记。
    if ($curPage > 1) {
        echo "<li><a class='w3-hover-sand w3-pale-blue ' href = 'message.php?curPage=" . ($curPage - 1) . "'>&laquo;</a></li>";
         echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'message.php?curPage=1'>首页</a></li>";
            }
     for ($i = 1; $i <= $pages; $i++) {//循环显示，每个链接指定curPage属性为其指向的页数就可以了
            echo "<li><a class = 'w3-light-grey w3-hover-aqua'  href='message.php?curPage=",$i,"'>$i</a></li>","&nbsp;";
         }       
        //如果不是第一页的话就有上一页和首页的标记。
        if ($curPage < $pages) {
            echo "<li><a class='w3-hover-sand w3-pale-blue' href='message.php?curPage=" . ($curPage + 1) . "'>&raquo;</a></li>";
            echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'message.php?curPage=$pages'>末页</a></li>";
            }
            
          // 显示所有的记录信息
            echo "<br><br><li><a class='w3-hover-sand w3-pale-blue' >当前第" . $curPage . "页" . "/" . "共" . $pages . "页" . "/" . "每页显示" . $rowsPerPage . "条" . "/" . "共" . $rows . "条记录" . "<br></a></li></ul>";
if (!empty($_POST['submit'])) {
  // 如果点击了浏览按钮
	$id = $_POST['ID'];
  // 就把隐藏域的值赋值给一个变量
	header("Location:http://joker.joker.dxdc.net/Utopia_BBS/reply/reply.php?id=$id");
   // header("Location:http://localhost/Utopia_BBS/reply/reply.php?id=$id");  

    // PHP跳转页面。
  // 然后跳转到该id对应的帖子
}
	
}
else{
	 echo '<script type="text/javascript">
            alert("请您登陆后再试");
      document.location.href="../Login/index.php";
      </script>';
}
// 如果用户表示SESSION_['sign']不存在的话就提示用户，请你登陆后再试！
 ?>
</body>
</html>