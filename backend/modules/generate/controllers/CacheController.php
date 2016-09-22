<?php

namespace backend\modules\generate\controllers;

use Yii;
use librarys\controllers\backend\BackController;
use common\models\Cache;
use common\models\CacheHelper;
use common\models\Disease;
use common\models\Symptom;
use common\models\disease\Article as DArticle;

//use librarys\helpers\plugin\Paging;

/**
 * Description of CacheController
 */
class CacheController extends BackController {

    static public $length = 1000;
    /**
     * 缓存列表
     */
    public function actionIndex() {
        $data = [];
        $res = Cache::getCacheList();
        $data['cache'] = $res;
        return $this->render('index', $data);
    }

    /**
     * 生成缓存
     * ajax 请求
     */
    public function actionGenerateCache() {
        $this->disableLayout();
        //生成缓存 参数
        $id = $this->helpGpost('id', '');
        $offset = $this->helpGpost('offset', 0);
        $message = '';
        if (!empty($id)) {
            //生成缓存的  方法、所需查询的数据库
            $res = Cache::getCacheById($id);
            if (strpos($res['source'], 'article') !== false) {
                $message = $this->articleCache($res,$offset);
            } elseif (strpos($res['source'], 'disease') !== false) {
                $message = $this->diseaseCache($res,$offset);
            } elseif (strpos($res['source'], 'symptom') !== false) {
                $message = $this->symptomCache($res,$offset);
            } else {
                $message = $this->uniqueCache($res);
            }
        }
            $this->helpResult(['code' => '200', 'message' => $message, 'data' => '']);
    }
    public function actionRequest() {
        $id = $this->helpGpost('id', '');
        $count = '';
        $length = self::$length;
        if (!empty($id)) {
            $count = $this->dispatch($id);
            $cou = ceil($count / $length);
        }
        $this->helpResult(['code' => '666', 'message' => $cou, 'data' => '']);
    }

    private function dispatch($id) {
        $count = '';
        //生成缓存的  方法、所需查询的数据库
        $res = Cache::getCacheById($id);
        if (strpos($res['source'], 'article') !== false) {
            $count = $this->articleCache($res);
        } elseif (strpos($res['source'], 'disease') !== false) {
            $disease = new Disease();
            $count = $disease->getCount();
        } elseif (strpos($res['source'], 'symptom') !== false) {
            $symptom = new Symptom();
            $count = $symptom->getCount();
        } else {
            $count = 1;
        }

        return $count;
    }

    /**
     * 疾病缓存
     */
    public function diseaseCache($param = [],$offset) {
//        $disease = new Disease();
//        $res = $disease->getAllDisease();
        $disease = new Disease();
        $length = self::$length;
        $offset = ($offset-1)*$length;
//        $res = $symptom->getAllSymptom();
        $res = $disease->getDiseaseLimit([],$offset,$length);
        $i = 0;
        foreach ($res as $k => $v) {
            if (CacheHelper::$param['function']($param['key_prefix'], $v,true)) {
                $i++;
            } 
        }
        return $i;
    }

    /**
     * 症状缓存
     */
    public function symptomCache($param,$offset) {
        $symptom = new Symptom();
        $length = self::$length;
        $offset = ($offset-1)*$length;
//        $res = $symptom->getAllSymptom();
        $res = $symptom->getSymptomLimit([],$offset,$length);
        $i = 0;
        foreach ($res as $k => $v) {
            
            $ret = CacheHelper::$param['function']($param['key_prefix'], $v, true);
            if ($ret) {
                $i++;
            }
        }
        return $i; //'生成' . $i . '条';
    }

    /**
     * 文章缓存
     */
    public function articleCache($param) {
        $article = new DArticle();
        $res = $article->getAllArticle();
        $i = 0;
        foreach ($res as $k => $v) {
            if (CacheHelper::$param['function']($param['key_prefix'], $v,true)) {
                $i++;
            } 
        }
        return $i;
    }

    /**
     * 个别缓存
     */
    public function uniqueCache($param) {
        if (CacheHelper::$param['function']($param['key_prefix'], [],true)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 添加缓存名称
     */
    public function actionAdd() {
        return $this->render('add');
    }

    /**
     * 保存缓存 
     */
    public function actionSave() {
        $param = $this->helpGpost('param');
        if (!empty($param)) {
            $time = time();
            $con = [
                'name' => self::filterString($param['name']),
                'key_prefix' => self::filterString($param['key_prefix']),
                'function' => self::filterString($param['function']),
                'source' => self::filterString($param['source']),
                'description' => self::filterString($param['description']),
                'userid' => $this->user->id,
                'username' => $this->user->login_name,
                'updatetime' => $time,
            ];
            $id = (isset($param['id']) && !empty($param['id'])) ? $param['id'] : '';
            if ($id) {
                if (!Cache::edit($id, $con)) {
                    return $this->render('edit', Cache::getCacheById($id));
                }
                
                return $this->redirect('index');
            } else {
                $con['inputtime'] = $time;
                $cache = Cache::getCacheByKey($con['key_prefix']);
                if (!empty($cache)) {
                    return $this->render('add', ['message' => '缓存key已存在！']);
                }
                if (Cache::add($con)) {
                    return $this->redirect('index');
                }
            }
        }
    }

    /**
     * 编辑缓存
     */
    public function actionEdit() {
        $id = $this->helpGquery('id');
        if (!empty($id)) {
            $res = Cache::getCacheById($id);
            return $this->render('edit', $res);
        }
        return $this->run('index');
    }

    /**
     * 删除缓存
     */
    public function actionDel() {
        $ids = $this->helpGpost('ids', []);
        $message = '';
        $code = '';
        foreach ($ids as $k => $v) {
            if (Cache::del($v)) {
                $message = '删除成功！';
                $code = 'success';
            } else {
                $message = '删除失败！';
            }
        }
        return $this->helpResult(['code' => $code, 'message' => $message, 'data' => '']);
    }

    /**
     * 过滤数据
     * @param type $string
     * @return type
     */
    public static function filterString($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }
}
