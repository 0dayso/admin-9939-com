<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 14:11
 */

namespace api\models;

use api\models\Common;

class Image extends Common
{
    public static function upload($params)
    {
        if (isset($params['userid']) && isset($params['src'])) {
            $res = self::save($params);
            if ($res) {
                return Common::result(200, '图片上传成功！', ['image_url' => $res]);
            }
        }
        return Common::result(500, '图片上传失败！', []);
    }

    private static function save($params)
    {
        $base64_image_content = $params['src'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $date = date('Ym', time());
            $userid = $params['userid'];
            $uploads_path = "uploads/images/{$date}/";
            if (!is_dir($uploads_path)) {
                mkdir($uploads_path, 0777, true);
            }
            $new_file = "{$uploads_path}/{$userid}.jpeg";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                $image_url = \Yii::$app->homeUrl . "{$new_file}";
                return $image_url;
            }
        }
        return false;
    }

}