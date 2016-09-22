<?php
/**
 * @version 0.0.0.1
 */

namespace wapjb\models;

use common\models\Disease;
use common\models\Image;

/**
 * 文章服务类
 * @author gaoqing
 */
class ArticleService
{
    /**
     * 根据疾病id, 获取当前疾病相关疾病的图集
     * @author gaoqing
     * @date 2016-05-05
     * @param int $diseaseid 疾病id
     * @param int $size 所需的个数
     * @return array 相关疾病的图集
     */
   public static function getRelDiseaseImages($diseaseid, $size){
       $relDiseaseImages = [];

       //1、得到所有的相关疾病
       $disease = new Disease();
       $relDiseases = $disease->getDiseaseDisByDisid($diseaseid);

       //2、得到相关疾病的图集
       if (isset($relDiseases) && !empty($relDiseases)) {
           $notHasImages = [];
           $inner = [];
           $relDiseaseImagesIndex = 0;
            foreach ($relDiseases as $relDisease){
                $images = [];
                $inner['disease'] = $relDisease;
                $inner['images'] = $images;

                //2.1、如果当前图集，已经够 $size 了，就停止查询
                if ($relDiseaseImagesIndex == 6){
                    break;
                }
                //2.2、得到疾病图集
                $icondition = ['flag' => 1, 'relid' => $relDisease['id']];
                $imagesTemp = Image::search($icondition);
                if (isset($imagesTemp['list']) && !empty($imagesTemp['list'])) {
                    $images = $imagesTemp['list'];
                    $inner['images'] = $images;

                    $relDiseaseImages[] = $inner;
                    $relDiseaseImagesIndex++;
                }else{
                    $notHasImages[] = $inner;
                }
            }
           $relDiseaseImagesCount = count($relDiseaseImages);
           /*
            * 3.1、当前 $relDiseaseImages 中不到指定的个数 $size时：
            * 3.2、计算出，距离 $size 所需的个数 $needCount
            * 3.3、从 $notHasImages 中，提前 $needCount 个数据
            */
           if ($relDiseaseImagesCount < $size){
                $needCount = $size - $relDiseaseImagesCount;
                $needArr = array_slice($notHasImages, 0, $needCount);
               $relDiseaseImages = array_merge($relDiseaseImages, $needArr);
           }
       }
       return $relDiseaseImages;
   }
}