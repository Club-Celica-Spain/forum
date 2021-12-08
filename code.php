<?php 
    session_start(); 
     

    $captchaCode = substr(sha1(microtime() * mktime()), 0, 6); 
    $_SESSION['CAPTCHA_CODE'] = sha1($captchaCode); 
     

    $img = imagecreatetruecolor(70, 25); 
     

    $bgColor = imagecolorallocate($img, 88, 172, 250); 
    $stringColor = imagecolorallocate($img, 255, 255, 255); 
    $lineColor = imagecolorallocate($img, 6, 17, 118); 
     

    imagefill($img, 0, 0, $bgColor); 
     
    imageline($img, 0, 5, 70, 5, $lineColor); 
    imageline($img, 0, 10, 70, 10, $lineColor); 
    imageline($img, 0, 15, 70, 15, $lineColor); 
    imageline($img, 0, 20, 70, 20, $lineColor); 
    imageline($img, 12, 0, 12, 25, $lineColor); 
    imageline($img, 24, 0, 24, 25, $lineColor); 
    imageline($img, 36, 0, 36, 25, $lineColor); 
    imageline($img, 48, 0, 48, 25, $lineColor); 
    imageline($img, 60, 0, 60, 25, $lineColor); 
     

    imageString($img, 5, 8, 5, $captchaCode, $stringColor); 
     

    header("Content-type: image/png"); 
    imagepng($img); 
?> 