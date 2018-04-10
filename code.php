<?php
/*
PHPqrCode是一个PHP二维码生成类库，利用它可以轻松生成二维码，官网提供了下载和多个演示demo，

查看地址：http://phpqrcode.sourceforge.net/。
    下载官网提供的类库后，只需要使用phpqrcode.php就可以生成二维码了，当然您的PHP环境必须开启支持GD2。 phpqrcode.php提供了一个关键的png()方法，其中参数$text表示生成二位的的信息文本；参数$outfile表示是否输出二维码图片 文件，默认否；参数$level表示容错率，也就是有被覆盖的区域还能识别，分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）； 参数$size表示生成图片大小，默认是3；参数$margin表示二维码周围边框空白区域间距值；参数$saveandprint表示是否保存二维码并 显示。



调用PHP qrCode非常简单，如下代码即可生成一张内容为"http://www.****.cn"的二维码.
 */
header("Content-type: text/html; charset=utf-8");
$shape = $_POST['shapeSize'];//二维码大小
$margin = $_POST['marginSize'];//外边距留白大小
$allow = $_POST['allow'];//允许容错级别
$content = $_POST['content'];//允许容错级别

$fileInfo = $_FILES['logo'];
$imgname = isset($fileInfo['name'])?"logo":'';
$tmp = $fileInfo['tmp_name'];
$filepath = '';
if(move_uploaded_file($tmp,$filepath.$imgname.".png")){
   // echo "上传成功";
}else{
  //  echo "上传失败";
}

include 'phpqrcode.php';

$value = $content; //二维码内容

$errorCorrectionLevel = $allow;//容错级别

$matrixPointSize = $shape;//生成图片大小

//生成二维码图片

QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, $margin);


$QR = 'qrcode.png';//已经生成的原始二维码图

if(!$fileInfo['error']){
    $logo = 'logo.png';//准备好的logo图片

    if ($logo !== FALSE) {

        $QR = imagecreatefromstring(file_get_contents($QR));

        $logo = imagecreatefromstring(file_get_contents($logo));

        $QR_width = imagesx($QR);//二维码图片宽度

        $QR_height = imagesy($QR);//二维码图片高度

        $logo_width = imagesx($logo);//logo图片宽度

        $logo_height = imagesy($logo);//logo图片高度

        $logo_qr_width = $QR_width / 5;

        $scale = $logo_width/$logo_qr_width;

        $logo_qr_height = $logo_height/$scale;

        $from_width = ($QR_width - $logo_qr_width) / 2;

//重新组合图片并调整大小

        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,

            $logo_qr_height, $logo_width, $logo_height);

    }
    imagepng($QR, 'helloweba.png');
    echo '<img src="helloweba.png">';
}else{
    echo '<img src="qrcode.png">';
}

//输出图片






?>