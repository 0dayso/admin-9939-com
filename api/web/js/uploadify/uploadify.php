<?php
/*
 * Uploadify Copyright (c) 2012 Reactive Apps, Ronnie Garcia Released under the
 * MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

// Define a destination
$targetFolder = '/uploads'; // Relative to the root

$verifyToken = md5 ( 'unique_salt' . $_POST ['timestamp'] );

if (! empty ( $_FILES ) && $_POST ['token'] == $verifyToken) {
    $tempFile = $_FILES ['Filedata'] ['tmp_name'];
    $targetPath =$_SERVER ['DOCUMENT_ROOT'] . $targetFolder.'/'.'2';
    if(!file_exists($targetPath)){
        mkdir($targetPath);
    }
    $targetFile = rtrim ( $targetPath, '/' ) . '/' . $_FILES ['Filedata'] ['name'];
    
    // Validate the file type
    $fileTypes = array (
            'jpg',
            'jpeg',
            'gif',
            'png',
            'pdf' 
    ); // File extensions
    
    if(file_exists(iconv ( "UTF-8", "gb2312", $targetFile ))){
        $msg =  $_FILES ['Filedata'] ['name'].'文件已存在!';
        echo $msg;
        return;
    }
    $fileParts = pathinfo ( $_FILES ['Filedata'] ['name'] );
    if (in_array (strtolower($fileParts ['extension']), $fileTypes )) {
        move_uploaded_file ( $tempFile, iconv ( "UTF-8", "gb2312", $targetFile ) );
        
        $retArr = array();
        foreach($fileParts as $key=>$value){
            array_push($retArr, "'$key':'$value'");
        }
        echo '{'.implode(',', $retArr).'}';
    } else {
        echo 'Invalid file type.';
    }
}
?>