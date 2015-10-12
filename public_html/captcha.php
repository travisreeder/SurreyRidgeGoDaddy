<?php
session_start();

function random($length) {
	$chars = "abcdefghijklmnopqrstuvwxyz123456789";
	$str = "";
	$size = strlen($chars);
	for($i=0;$i<$length;$i++){
		$str .=$chars[rand(0, $size-1)];
	}
	return $str;
}

$cap = random (7);
$_SESSION['real'] = $cap;

$image = imagecreate(100, 20);
$background = imagecolorallocate($image, 48,35,29);
$foreground = imagecolorallocate($image, 246,241,237);

imagestring($image, 5,5,1,$cap,$foreground);
header("Content-type: image/jpeg");
imagejpeg($image);
?>