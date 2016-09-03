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
    session_start();
    // 开启session
    $sign = $_SESSION['sign'];
     // 并且把用户标识的值赋值给一个变量
    $title = $_POST['title'];
    // 吧标题赋值给一个变量
    $content = $_POST['hid_img'];
    // 把内容复制给一个变量
    $reply = 0;
    $browse = 0;
    $message = 0;
    // 刚发的帖子的回复和浏览都是0
    if (!empty($content) && !empty($title)) {
      // 如果标题和内容都不为空的话，就执行下面的插入sql语句
$sql = "INSERT INTO `tb_publish` (`title`,`content`,`username`,`time`,`reply`,`browse`,`message`) VALUES ('$title','$content','$sign',now(),'$reply','$browse','$message')";
// 吧隐藏域传过来的内容插入到数据库，数据库tag字段的类型设置为text类型，因为varchar类型只支持255个字符，而text的长度为2**16-1 也就是65535个字符，完全够用。用来做大型的BBS用此类型
  mysqli_query($conn, $sql);
  // 执行查询语句
  mysqli_close($conn);
  // 关闭查询连接
  if ($sign == 'administrator') {
      echo '<script type="text/javascript">
            alert("发帖成功！");
      document.location.href="../administrator/show_card.php";
      </script>';
      // 给用户一个提示，你已经发帖成功。并且跳转到显示帖子的界面
  }
  else{
  echo '<script type="text/javascript">
            alert("发帖成功！");
			document.location.href="../show_card/show_card.php";
			</script>';
      // 给用户一个提示，你已经发帖成功。并且跳转到显示帖子的界面
  }
}
  else{
    echo '<script type="text/javascript">
            alert("标题或内容不能为空，请你重新输入~");
      document.location.href="publish.php";
      </script>';
      // 如果为空的话就提示用户标题或者内容不能为空，请用户重新输入，然后刷新该界面
}
	 ?>
</body>
</html>