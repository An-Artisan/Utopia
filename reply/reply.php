<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/w3.css">
     <style type="text/css">
        body{
            margin: 0 auto;
            overflow: auto;
            background: #d9d6c3;
            width: 1000px;
            }
            /*设置显示帖子的宽度*/
       .bottom{
        position: fixed;
        bottom: 0;
       }
       /*设置编辑器的位置*/
      </style>
    <script type="text/javascript" src="../js/emoji.js"></script>
    <!-- 连接表情库 -->
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=6Yap8oeS4Ux6MBDIClrH7KfHREyOuiIU"></script>
    <!-- 连接百度地图API -->
</head>
<body>

    <div id="">
	<?php 
    include '../conn/conn.php';
    // 把连接数据库的文件包含过来
    session_start();
     if(empty($_SESSION['sign'])){
        // 如果SESSION用户标识不存在就提示用户请他登录后再试！
    	  echo '<script type="text/javascript">
            alert("请您登陆后再试");
      document.location.href="../Login/index.php";
      </script>';
      // 并且跳转到登录界面
  
    }
    else{	
    echo    "<ul class='w3-ul w3-light-grey w3-card-4'><li class='w3-padding-16'>";
    @$id = $_GET['id'];
    // 获取显示帖子界面传过来的ID
    $_SESSION['id'] = $id;
    // 然后把ID赋值给session
    $sql = "select * from `tb_publish` where `ID` = '$id'";
    // 查询该id的回复
    $result = mysqli_query($conn,$sql);
    // 执行sql语句
    $object = mysqli_fetch_object($result);
    // 找到查询结果集
    $username = $object -> username;
    // 把用户名赋值给一个变量
    $sql = "select * from `tb_register` where `UserName` = '$username'";
    // 查询该用户发的主题帖，显示在屏幕上
    $result = mysqli_query($conn,$sql);
    // 执行查询语句
    $object_picture = mysqli_fetch_object($result);
    // 找到查询结果集
    $picture = $object_picture -> Head_filename;
    // 输出头像
	$arr = explode('·',$object -> content);

	// 每条记录分割取表情和文字
     
     echo "<img class='w3-left w3-circle w3-margin-right' style='width:60px;height:60px;' src='../Register/upfile/",$picture,"'>";
     // 显示头像
     echo "<span class='w3-xlarge'>";
	for ($j=0; $j < count($arr)-1; $j++) { 
    if(substr($arr[$j], 0,2)=='(:'){
    	// 如果是(:开头的表示是表情
         echo  "<img style = 'width:33;height:33px;' src='../img/emoji_",substr($arr[$j],2),".png'>";
	 // 当选择多个表情同时发送时，用explode来分割判断输出

	}
	else{
        echo $arr[$j];
    // 否则就是文字
	}
   
}
    

   echo "</span><br>";
   echo "<span >用户:","<a>",$object -> username,"</a>&nbsp;发帖时间:",$object -> time,"&nbsp;性别:",$object_picture -> Sex,"&nbsp;邮箱:",$object_picture -> E_mail,"</span></li>";
    // 显示发帖的时间用户名等等~ 
    $browse = $object -> browse;
    // 然后把浏览字段取出来
    $reply = $object -> reply;
    // 吧回复字段取出来
    $message = $object -> message;
    // 把消息字段取出来
    $browse ++; 
    // 如果点进来了这个界面就代表浏览一次就+1
    $sql = "UPDATE `tb_publish` SET  `browse` = '$browse' WHERE `ID` = '$id'";
    // 然后修改浏览次数
    mysqli_query($conn,$sql);
    // 执行查询语句
    if (!empty($_POST['submit'])) {
        // 如果点击了发送按钮，就执行以下的代码

    	   function getIP() {
            // 该函数是获取用户的IP 
            static $realip;
            if (isset($_SERVER)){
                if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                    $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                    $realip = $_SERVER["REMOTE_ADDR"];
                    }
            } 
                    return $realip;
                    }
           $ip = getIP();
           // 调用获取IP的函数
    	   $content = $_POST['hid_img'];
           // 把隐藏域的值取出来
    	   $sign = $_SESSION['sign'];
           // 把用户标识赋值给一个变量
    	   $id = $_SESSION['id'];
           // 吧用户ID赋值给一个变量
    	   $city_name = $_POST['baidu_map'];
           // 然后获取发帖的城市
    	   $sql = "INSERT INTO `tb_reply` (`username`,`content`,`ID`,`reply_time`,`city_name`,`reply_ip`) VALUES ('$sign','$content','$id',now(),'$city_name','$ip')";
           // 然后添加到数据库中
    	   mysqli_query($conn,$sql);
           // 执行查询语句
    	   $reply ++;
           // 同时回复的次数+1
           $message ++;
    	   $sql = "UPDATE `tb_publish` SET  `reply` = '$reply',`message` = '$message' WHERE `ID` = '$id'";
           // 执行查询语句
    	   mysqli_query($conn,$sql);

    }
    $rowsPerPage = 3;
    //定义每页的行数
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) AS count FROM `tb_reply` where `ID` ='$id' "));
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
    $sql = "select * from `tb_reply` where `ID` = '$id'  LIMIT ". ($curPage - 1) * $rowsPerPage . ",$rowsPerPage   ";
    // 显示ID为该帖子的记录
    $result_id = mysqli_query($conn,$sql);
    // 执行查询语句
    $object = mysqli_fetch_object($result_id);
    // 获取查询结果集
    if (@!($object -> ID)){
        // 如果没有记录，就代表没有人回复，提示用户，当前没有人回复！
    	echo "<p style = 'font-size :20px;text-align:center;'>&nbsp;当前没有回复~</p>";
    }
    else{
        // 否则就是有人回复
      do{
        // 取出来用户名作为查询条件
        $username = $object -> username;
        $sql = "select * from `tb_register` where `UserName` = '$username'";
        // 查询用户名为当前用户名
        $result = mysqli_query($conn,$sql);
        // 执行查询语句
        $object_picture = mysqli_fetch_object($result);
        // 获取查询结果集
        $picture = $object_picture -> Head_filename; 
        // 吧头像的文件名获取到
        echo "<li class='w3-padding-16'><img class='w3-left w3-circle w3-margin-right' style='width:60px;height:60px;' src='../Register/upfile/",$picture,"'>";
        // 显示头像在浏览器上
        echo '<span class="w3-xlarge">';
        $arr = explode('·',$object -> content);
    // 每条记录分割取表情和文字
    for ($j=0; $j < count($arr)-1; $j++) { 
    if(substr($arr[$j], 0,2)=='(:'){
        // 如果是(:开头的表示是表情   
        echo  "<img style = 'width:33;height:33px;' src='../img/emoji_",substr($arr[$j],2),".png'>";
     // 当选择多个表情同时发送时，用explode来分割判断输出

    }
    else{
    echo $arr[$j];
    // 否则就是文字
    }

}
echo "</span><br>";
  // 显示回帖用户的所有信息
 echo " <span>用户:","<a>",$object -> username,"</a>","&nbsp;回帖时间:",$object -> reply_time,"&nbsp;","&nbsp;性别:",$object_picture -> Sex," 邮箱:",$object_picture -> E_mail," 回帖城市:",$object -> city_name," ip:",$object -> reply_ip,"</span>";
    echo " </li>";
      }while($object = mysqli_fetch_object($result_id));

    }
    echo "</ul>";
    echo "<div style = 'text-align:center;'>";
    echo '<ul class="w3-pagination  ">';
   // 如果不是第一页的话就有上一页和首页的标记。
    if ($curPage > 1) {
        echo "<li><a class='w3-hover-sand w3-pale-blue ' href = 'reply.php?id=",$id,"&curPage=" . ($curPage - 1) . "'>&laquo;</a></li>";
         echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'reply.php?id=",$id,"&curPage=1'>首页</a></li>";
            }
     for ($i = 1; $i <= $pages; $i++) {//循环显示，每个链接指定curPage属性为其指向的页数就可以了
            echo "<li><a class = 'w3-light-grey w3-hover-aqua'  href='reply.php?id=",$id,"&curPage=",$i,"'>$i</a></li>","&nbsp;";
         }       
        //如果不是第一页的话就有上一页和首页的标记。
        if ($curPage < $pages) {
            echo "<li><a class='w3-hover-sand w3-pale-blue' href='reply.php?id=",$id,"&curPage=" . ($curPage + 1) . "'>&raquo;</a></li>";
            echo "<li><a class='w3-light-grey w3-hover-aqua' href = 'reply.php?id=",$id,"&curPage=$pages'>末页</a></li>";
            }
            
            // 显示所有的查询记录信息
            echo "<br><br><li><a class='w3-hover-sand w3-pale-blue' >当前第" . $curPage . "页" . "/" . "共" . $pages . "页" . "/" . "每页显示" . $rowsPerPage . "条" . "/" . "共" . $rows . "条记录" . "<br></a></li></ul>";
    echo " </div>";
     }
     mysqli_close($conn);
	 ?>
	<div class="bottom">  
    <form style="margin-right: 40px;"  action="reply.php?id=<?php echo $id;?>" method="post">
    <!-- 接受的表单加上当前ID -->
    <br>
    <div>
    
     <div id="div1" style="display:none;"><!--表情包-->
    <img id="img1" src="../img/emoji_1.png">   
    <img id="img2" src="../img/emoji_2.png">
    <img id="img3" src="../img/emoji_3.png">
    <img id="img4" src="../img/emoji_4.png">
    <img id="img5" src="../img/emoji_5.png">
    <img id="img6" src="../img/emoji_6.png">
    <img id="img7" src="../img/emoji_7.png">
    <img id="img8" src="../img/emoji_8.png">
    <img id="img9" src="../img/emoji_9.png">
    <img id="img10" src="../img/emoji_10.png">
    <br>
    <img id="img11" src="../img/emoji_11.png">
    <img id="img12" src="../img/emoji_12.png">
    <img id="img13" src="../img/emoji_13.png">
    <img id="img14" src="../img/emoji_14.png">
    <img id="img15" src="../img/emoji_15.png">
    <img id="img16" src="../img/emoji_16.png">
    <img id="img17" src="../img/emoji_17.png">
    <img id="img18" src="../img/emoji_18.png">
    <img id="img19" src="../img/emoji_19.png">
    <img id="img20" src="../img/emoji_20.png">
    <br>
    <img id="img21" src="../img/emoji_21.png">
    <img id="img22" src="../img/emoji_22.png">
    <img id="img23" src="../img/emoji_23.png">
    <img id="img24" src="../img/emoji_24.png">
    <img id="img25" src="../img/emoji_25.png">
    <img id="img26" src="../img/emoji_26.png">
    <img id="img27" src="../img/emoji_27.png">
    <img id="img28" src="../img/emoji_28.png">
    <img id="img29" src="../img/emoji_29.png">
    <img id="img30" src="../img/emoji_30.png"> 
    <br>
    <img id="img31" src="../img/emoji_31.png">
    <img id="img32" src="../img/emoji_32.png">
    <img id="img33" src="../img/emoji_33.png">
    <img id="img34" src="../img/emoji_34.png">
    <img id="img35" src="../img/emoji_35.png">
    <img id="img36" src="../img/emoji_36.png"> 
    <img id="img37" src="../img/emoji_37.png"> 
    <img id="img38" src="../img/emoji_38.png">
    <img id="img39" src="../img/emoji_39.png">
    <img id="img40" src="../img/emoji_40.png"> 
    </div>   
    
     <div id="btn">
        <img src="../img/picture_btn.png"/>
        </div>
    <div id="div2"  style="border: 1px solid black;overflow:auto;width:1000px;margin:0 auto;height: 50px; " contenteditable="true"></div><!--消息编辑框 -->
    <input id="send" name="submit" type="submit" value="发送">
    <input type="hidden" name="hid_img" value="" id="hid_img">
    <!-- 隐藏域用来把内容传给PHP -->
    <input type="hidden" name="baidu_map" value="" id="baidu_map">
    <!-- 百度地图API接收到回帖城市 -->
    </form>
    </div>
    </div>
    </div>
</body>
</html>