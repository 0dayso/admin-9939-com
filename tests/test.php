<?php
/**
 * @version 0.0.0.1
 */

$str = <<<PHP_EOL
得了手足口病，饮食上要注意什么什么？
PHP_EOL;

$array = ['2', '1', 'gao', 'name' => '', ''];
$new_array = array_filter($array, function ($value){
    if (empty($value)){
        return false;
    }
    return true;
});

print_r($new_array);




