<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads'; // Relative to the root and should match the upload folder in the uploader script

//进行 MD5 加密处理
$name = strstr($_POST['filename'], ".", true);
$suffix = strstr($_POST['filename'], ".");
$filename = md5($name) . $suffix;

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' . $filename)) {
	echo 1;
} else {
	echo 0;
}
?>