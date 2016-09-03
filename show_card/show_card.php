<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
  <link rel="stylesheet" type="text/css" href="../css/w3.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <style type="text/css">
  body{
    background: #f2eada;
  }
  /*设置该界面的背景颜色*/
  </style>
   
</head>
<body>
<?php  
      session_start();
      // 开启session
    if(empty($_POST['submit'])){
      // 如果没有点击搜索帖子就执行以下的代码
    if (!empty($_SESSION['sign'])) {
      // 如果用户标识存在的话就执行以下的代码
      header("Content-type: text/html; charset=utf-8");
      $servername = "localhost";
      $username = "root";
      // $username = "root";
      $password = "JokerHosting520";
      //$password = "liuqiang";
      $dbName = "Utopia";
      // $dbName = "mydb";
      date_default_timezone_set('PRC');
      //日期设置为中华人民共和国
      $conn = mysqli_connect($servername, $username, $password, $dbName);
      // 建立SQL连接
      mysqli_query($conn, "set names utf8;");
      //查询的字符格式设置为utf-8s
?>
  <ul class="w3-navbar w3-card-2 w3-light-grey" style = 'float:right'>
  <?php 
  $message = 0;
  $sql = "select `message` from `tb_publish` where `username` = '$_SESSION[sign]'";
  $sql = mysqli_query($conn,$sql);
  while ($object_message = mysqli_fetch_object($sql)) {
    $message += $object_message -> message;
      }
    mysqli_free_result($sql);
    // 关闭查询结果集
  if ($message) {
  echo '<li><a href="../reply/message.php" target="_blank">你有',$message,'条新回复</a></li>';
  }

   ?>
  <li class="w3-dropdown-click">
    <a onclick="myFunction()"><?php echo  $_SESSION['sign']; ?> <i class="fa fa-caret-down"></i></a>
    <div id="demo" class="w3-dropdown-content w3-white w3-card-4">
    <!-- 显示用户名 -->
      <a href="../personal_data/personal_data.php" target='_blank'>个人资料</a>
      <a href="../administrator/My_Card.php?username=<?php echo $_SESSION['sign'] ?>" target='_blank'>我的帖子</a>
      <a href="../sign_out/sign_out.php">退出登录</a>
      <!-- 跳转到退出登陆界面 -->
    </div>
  </li>
  <li><a href="../publish/publish.php">发帖</a></li>
  <!-- 跳转到发帖界面 -->
</ul>
<li  style="font-size: 40px;
        list-style-type:none;
        text-align: center;
        color: #006400;">UTOPIA</li>
        <!-- 显示论坛名称 -->
<div id="input" class="w3-container w3-padding-16" style="max-width:800px;margin: 0 auto">
<form class="w3-container" action = "show_card.php"  method="post"  ><input class = "w3-input" name = "search" type="text" onblur= "this.focus();"><input class = "w3-btn w3-blue-grey" id="id" name = "submit" type="submit" value="搜索帖子"  /></form>
<!-- 设置一个表单程序，搜索帖子，当前界面来处理该表单 -->
</div>
<script>
function myFunction() {
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>
    <?php
      
      $rowsPerPage = 3;
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
      // $sql = "select * from `publish` order by `time` desc ";
      $sql = "select * from `tb_publish` order by `time` desc LIMIT ". ($curPage - 1) * $rowsPerPage . ",$rowsPerPage  ";
      // 查询限制记录
      Getcard($sql,$curPage,$pages,$rowsPerPage,$rows);
      // 调用显示帖子函数
  }
  else{

    echo '<script type="text/javascript">
            alert("请您登陆后再试");
      document.location.href="../Login/index.php";
      </script>';
  // 如果用户标识名不存在就提示用户请登录后再试,跳转到登录界面
  }
}
else{
  // 代表点了搜索帖子按钮
  ?>
   <ul class="w3-navbar w3-card-2 w3-light-grey" style = 'float:right'>
  <li><a href="../show_card/show_card.php">返回贴子广场</a></li>
  <!-- 返回帖子广场的a连接标记 -->
  </ul>
  <li  style="font-size: 40px;
        list-style-type:none;
        text-align: center;
        color: #006400;">UTOPIA</li>
        <!-- 显示论坛名称 -->
  <?php
  $content = $_POST['search'];
  // 吧搜索文本框的内容赋值给一个变量
  $sql = "select * from `tb_publish` where `title` like  '%$content%' order by `time` desc  ";
  // 然后模糊查询
  Getcard($sql);
  // 调用显示帖子函数
  
}
function Getcard($sql,$curPage = NULL,$pages = NUll,$rowsPerPage = NULL,$rows = NULL){
      // 设置4个默认值
      include_once '../conn/conn.php'; 
      // 吧连接数据库的文件包含过来
      $sql = mysqli_query($conn,$sql);
      // 执行查询语句
      $object = mysqli_fetch_object($sql);  
      // 获取查询结果集
      if (@!($object -> ID)){
      echo '
        <br><br><br><br><br><br>
        <div style="font-size: 40px;
        list-style-type:none;
        text-align: center;
        color: #006400;">抱歉，没有帖子！</div>';
    }
    // 如果没有查询到结果,就提示用户,没有帖子
    else{
      
      echo '<div class="w3-container  w3-padding-16" style="max-width:1000px;margin: 0 auto;" >
          <ul class="w3-ul w3-sand w3-card-4">';
      do{
        $username = $object -> username;
        // 获取用户名,作为查询条件
        $sql_username = "select * from `tb_register` where `UserName` = '$username'";
        // 去注册表查询用户该信息
        $result = mysqli_query($conn,$sql_username);
        // 执行查询语句
        $object_picture = mysqli_fetch_object($result);
        // 获得查询结果集
        $picture = $object_picture -> Head_filename;
        // 以用户名查询，然后去找到注册表中时候的头像
        echo "<li class='w3-padding-16 '><img class='w3-left w3-circle w3-margin-right' style='width:60px;height:60px;' src='../Register/upfile/",$picture,"'><a  href='../reply/reply.php?id=".$object -> ID."' target='_blank' >" , $object -> title,"</a>" ,"&nbsp;" , "<span style = 'float:right' class='w3-medium'>回复(" , $object -> reply ,")" , "/" , "浏览(" ,$object -> browse , ")" , '<br></span><br><br>';
        // 显示发帖用户的信息和帖子信息
        echo "<a ",$object -> username,">",$object -> username,"</a>","&nbsp;","<span  style = 'float:right' >",$object -> time,"</span></li>";
        // 显示发帖时间用户名等~
      }while($object = mysqli_fetch_object($sql));

    }
   echo "</ul></div>";
    echo "<div style = 'text-align:center;'>";
    echo '<ul class="w3-pagination  ">';
   // 如果不是第一页的话就有上一页和首页的标记。
    if ($curPage > 1) {
        echo "<li><a class='w3-hover-sand w3-pale-blue ' href = 'show_card.php?curPage=" . ($curPage - 1) . "'>&laquo;</a></li>";
         echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'show_card.php?curPage=1'>首页</a></li>";
            }
     for ($i = 1; $i <= $pages; $i++) {//循环显示，每个链接指定curPage属性为其指向的页数就可以了
            echo "<li><a class = 'w3-light-grey w3-hover-aqua'  href='show_card.php?curPage=",$i,"'>$i</a></li>","&nbsp;";
         }       
        //如果不是第一页的话就有上一页和首页的标记。
        if ($curPage < $pages) {
            echo "<li><a class='w3-hover-sand w3-pale-blue' href='show_card.php?curPage=" . ($curPage + 1) . "'>&raquo;</a></li>";
            echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'show_card.php?curPage=$pages'>末页</a></li>";
            }
            
        //显示所有的帖子信息,第几页等等~ 
            echo "<br><br><li><a class='w3-hover-sand w3-pale-blue' >当前第" . $curPage . "页" . "/" . "共" . $pages . "页" . "/" . "每页显示" . $rowsPerPage . "条" . "/" . "共" . $rows . "条记录" . "<br></a></li></ul>";
    echo " </div>";
mysqli_close($conn);
}

?>
  
</body>
</html>