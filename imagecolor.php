<?php
// $im = imagecreatefrompng("http://depextechnologies.org/okay-click/images/package_image/index.jpeg");
// $rgb = imagecolorat($im, 10, 15);
// $r = ($rgb >> 16) & 0xFF;
// $g = ($rgb >> 8) & 0xFF;
// $b = $rgb & 0xFF;

// var_dump($r, $g, $b);

 $image=imagecreatefromjpeg('http://depextechnologies.org/okay-click/images/package_image/SSL-Secure-Web-Hosting-Silver.jpg');
  $thumb=imagecreatetruecolor(1,1); imagecopyresampled($thumb,$image,0,0,0,0,1,1,imagesx($image),imagesy($image));
    $mainColor=strtoupper(dechex(imagecolorat($thumb,0,0)));
  echo $mainColor;

?>
<div style="background-color: <?php echo $mainColor;?>;" height="200px" width="200px">dfgdfgdfgdfg</div>


