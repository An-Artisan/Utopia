<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/w3.css">
 <script type="text/javascript" src="../js/emoji.js"></script>
 <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=6Yap8oeS4Ux6MBDIClrH7KfHREyOuiIU"></script>
 <style type="text/css">
 body{
     background: #d5c59f;
 }
 /*设置整个页面的背景颜色*/
 .center{
    width: 600px;
    margin: 0 auto;
     }
     /*设置宽度*/
.bottom{
    position:fixed;
    bottom:0;
  }
  /*设置编辑器的位置，永远处于浏览器的最下面*/
 </style>
</head>
<body>  
<div style="width: 300px;background: #feeeed; opacity: 0.8;-moz-border-radius: 10px;
-webkit-border-radius: 10px;border-radius:10px; position:relative;bottom: 0;float: right;color: #006400;font-size: 30px;text-align: left;">推荐贴子
<!-- 推荐帖子发在最右边 -->
<div style="width: 200px;font-size: 18px;text-align: left;color: #78a355">
    <?php 
    include_once '../conn/conn.php';
    // 把连接数据库的文件包含过来
    $sql = "select * from `tb_publish`  order by `reply` desc ,`browse` desc limit 0,5  ";
    // 查询回复和浏览次数最高的帖子，只查询5条记录
    $result = mysqli_query($conn,$sql);
    // 执行查询语句
    while ($object = mysqli_fetch_object($result)) {
        echo "<a href='../reply/reply.php?id=",$object -> ID,"'>",$object -> title,"</a><br>";
        // echo "<a href='reply.php?id='>",$object -> title,"</a><br>";
    }
    // 然后输出到屏幕上
    mysqli_free_result($result);
    // 关闭查询结果集
     ?>
</div>
</div>
<div class="center" >
 <ul class="w3-navbar w3-card-2 w3-light-grey" style = 'float:right'>
  <li><a href="../show_card/show_card.php">返回贴子广场</a></li>
  <!-- 设置一个返回到帖子广场的a标记链接 -->
  </ul>
	<li  style="font-size: 40px;
        list-style-type:none;
        text-align: center;
        color: #006400;">UTOPIA</li>
	<!-- 显示论坛名称 -->
    <div class="bottom">
    <form style="margin-right: 40px;"  action="dispose_publish.php" method="post">
    <input  type="text" class="w3-input w3-sand" style=" width:600px;height:40px; font-size: 30px;  " value="输入您的帖子标题" name="title" onclick="this.value = '';"  >
    <!-- 发帖的标题 -->
    <br>
    <br> 
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
        <!-- 表情按钮 -->
    <div id="div2" style="border: 1px solid black;width: 600px;overflow:auto;height: 100px; " 
    contenteditable="true"></div><!--消息编辑框 -->
    <!-- contenteditable="true" 的意思是使div可以编辑，但是光标不会自动获取焦点 -->
    <input id="send" type="submit" value="发送">
    <input type="hidden" name="hid_img" value="" id="hid_img">
    <!-- 隐藏域用来把内容传给PHP -->
    </form>
    </div>
    </div>
</body>
</html>