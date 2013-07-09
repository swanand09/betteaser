<?php
require_once 'ClassCaptcha.php';

$cod=new ClassCaptcha();
$capCode=$cod->generateCode();


$dir = 'fonts/';

$image = imagecreatetruecolor(100, 30);
$black = imagecolorallocate($image, 0, 0, 0);
$color = imagecolorallocate($image, 212, 82, 82); // red
$white = imagecolorallocate($image, 232, 232, 232); 

imagefilledrectangle($image,0,0,399,99,$white);

for ($i = 0; $i < 5; $i++) {
    imagettftext ($image, 20, $capCode[$i][1], 10+($i*15), 27, $color, $dir."arial.ttf", $capCode[$i][0]);
    $string .=$capCode[$i][0];
    
}

$cod->set_captcha($string);


header("Content-type: image/png");
imagepng($image);

?>