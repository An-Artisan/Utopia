<?php 
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