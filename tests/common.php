<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/29
 * Time: 15:03
 */

//include the file
defined("TMP_PATH") or define("TMP_PATH", "D:/gaoqing/software/wamp/www/PHPStorm");
require TMP_PATH . "/admin-9939-com/librarys/helpers/utils/Spell.php";


$name = "高青";
$pin = \librarys\helpers\utils\Spell::Pinyin($name, 'UTF-8', true);
$Bpin = strtoupper($pin[0]);
echo $Bpin;