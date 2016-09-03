<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php 
    session_start();
    $_SESSION['sign'] = array();
    // 给SESSION超全局数组赋值为空
    echo '<script type="text/javascript">
            alert("退出成功！");
      document.location.href="../Login/index.php";
      </script>';
      // 然后提示用户退出成功.跳转到登录界面
	 ?>
</body>
</html>