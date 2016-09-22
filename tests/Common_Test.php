<?php
/**
 * @version 0.0.0.1
 */

function callback($callback) {
    $callback();
}

//输出: This is a anonymous function.<br />\n
//这里是直接定义一个匿名函数进行传递, 在以往的版本中, 这是不可用的.
//现在, 这种语法非常舒服, 和javascript语法基本一致, 之所以说基本呢, 需要继续向下看
//结论: 一个舒服的语法必然会受欢迎的.

$obj = (object) "Hello, everyone";
$callback = function () use ($obj) {
    print "This is a closure use object, msg is: {$obj->scalar}. <br />\n";
};
$obj = (object) "Hello, everybody";
callback($callback);

echo $obj->toString();

