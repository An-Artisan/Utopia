
	window.onload = function (){//表情包
	var oBtn = document.getElementById('btn');
    // 获取图片表情按钮的值
	var oDiv = document.getElementById('div1');
    // 获取隐藏div区域的值
	var oImg = oDiv.getElementsByTagName('img');
    // 获取所有图片的值
	var oDiv_img = document.getElementById('div2');
    // 获取编辑区域的值，编辑区域用div来实现
	var oInput = document.getElementById('send');
    // 获取发送按钮的值
    var oHid_img = document.getElementById('hid_img');
    // 获取隐藏域的值
    var baidu_map = document.getElementById('baidu_map');
    // 隐藏域的值
    var point = new BMap.Point(116.331398,39.897445);
    // 以百度的ip地址为寻找点
    var str = ''; 
    // 给编辑框的数据存在str中
    var on_off = 1;
    // 设置表情的开关
    var cityName = '';
    // 城市位置
    function myFun(result){
     cityName = result.name;
    // 获取当前城市.
  }
  var myCity = new BMap.LocalCity();
  myCity.get(myFun);
  // 调用一个回调函数到百度API库里面

// 以上代码使div的contenteditable全局属性获取焦点
    oDiv_img.onfocus = function () {
        window.setTimeout(function () {
        var sel,range;
    if (window.getSelection && document.createRange) {
      range = document.createRange();
      range.selectNodeContents(oDiv_img);
      range.collapse(true);
      range.setEnd(oDiv_img, oDiv_img.childNodes.length);
      range.setStart(oDiv_img, oDiv_img.childNodes.length);
      sel = window.getSelection();
      sel.removeAllRanges();
      sel.addRange(range);
    } else if (document.body.createTextRange) {
      range = document.body.createTextRange();
      range.moveToElementText(oDiv_img);
      range.collapse(true);
      range.select();
    }
  }, 1);
}
oDiv_img.focus();
// 以上代码使div的contenteditable全局属性获取焦点
	oBtn.onclick=function(){
    if (on_off) {
		oDiv.style.cssText = 'position: absolute;border:1px groove black;margin-left:0;bottom:150px; left:0px;  margin 0 auto; z-index:10; background:#ccc; display:block;';
    on_off = 0;
      }
      else{
    oDiv.style.display = 'none';
    on_off = 1;
      }
	}
    // 单击表情图片，弹出图层
	

    // 双击表情图片隐藏图层
	for (var i = 0; i < oImg.length-1; i++) {
		oImg[i].index = i+1;
        // 给每一张的表情图片赋值一个新属性，后面有用
	oImg[i].onclick = function(){
        // 选择表情时发生的时间
		oDiv.style.display = 'none';
       // 选择表情后就关闭图层
	    oDiv_img.innerHTML += '<img src="../img/emoji_'+ this.index + '.png">';
       // 然后把选择的表情放在标记区域内
        var content =  oDiv_img.innerHTML;
        // 吧编辑区域的值先放在一个变量content中

        get_text_content(content);
        // get_text_content函数是获取编辑框内的文本值。
            function get_text_content(content){
      for(var i=0;i<content.length;i++){
        // 从0到编辑框的内容最后一个
              
       
        if(content.charAt(i) == '>'){
            // 如果编辑框的某个内容等于>说明后面的就是文字，因为>是img的结束标记。
            i++;
            // 设置一个变量i来自增
            while( content.charCodeAt(i) > 60 || content.charCodeAt(i) < 60 ){
                // 60的ASCII码对应的符号是<，如果循环的第i个字符不等于<的话才继续执行
                // 因为如果等于<的话说明两个表情是连续放在一起的。
               str += content.charAt(i);
               // 然后把后面的文字内容加上来。
               i++;
               // 在循环里面自增
            }

            str += '·';
            // 最后复制给str 而·是分隔符，到时候在PHP中用分割函数来分割。
            } 
        
 
      }
    }
	    str += ('(:' + this.index + '·'); 
        // 把数字所对应的表情放在数据库中,在标记框输入(:数字发出来就是表情
        oDiv_img.focus();      
         //  选择表情后div编辑框要获取焦点 
     }   
 }
	
  oInput.onclick = function (){
       var content = oDiv_img.innerHTML;
       // 吧编辑框的内容复制给一个变量
       var length = content.length;
       // 它的长度也复制给一个变量
       var sort = [];
       // 定义一个数组用来排序用
       var i = 0;
       // 数组的下标i从0开始
       var middle = '';
       // 定义一个中间变量
       length--;
       // 先减一个，因为数组是从0开始的。

       while(content.charCodeAt(length) > 62 || content.charCodeAt(length) < 62){
      // ASCII码对应的是>，如果不是>才继续执行，因为如果等于>的话 说明已经到图片的区域的。不能再取了，因为我是倒着取文字字符。
               sort[i] = content.charAt(length);
               // 吧文字字符放入一个数组内。
               length--;
               // 字符长度下标减一个
               i++;
               // 数组下标长度加一个
       }
       for( i = sort.length;i > 0;i--){
        str += sort[i-1];
       }
       // 上面for循环用来把之前的文字在倒过来。相当于把字符串倒序取出
        str += '·';
        //·是用来分割的。
       
       
        var position = content.indexOf('<');
        // 寻找第一个<的位置。如果没找到返回-1
        for(i = 0; i < position; i++){
            middle += content.charAt(i);
            // 然后把第一个<前面的内容复制给middle
        }
        middle += '·';
        // 然后middle加个·分割
        str = middle + str

        // 最后把middle放在最前面，因为这个是处理先输入文字，再输入表情。
    	oDiv_img.innerHTML = '';
        // 然后清空编辑框的内容
    	oHid_img.value = str;
        // 最后把所有内容赋值给一个隐藏域，用隐藏域传过去到PHP。
       baidu_map.value = cityName;

    }
}
