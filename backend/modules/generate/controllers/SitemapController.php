<?php

/**
 * @version 0.0.0.1
 */

namespace backend\modules\generate\controllers;

use common\models\Department;
use common\models\Disease;
use common\models\Part;
use common\models\Symptom;
use common\models\disease\Article;
use common\models\sitemap\Ztsitemap;
use librarys\controllers\backend\BackController;
use yii\web\Response;

class SitemapController extends BackController {

    public $_ownership; //xml 属于pc wap
    public $_baidu = false; //是否百度提交
    public $_changefreq = 'always';
    public $_priority = '0.6';

    public function init() {
        parent::init();
    }

    /**
     * 生成 sitemap 主页
     * @author gaoqing
     * @date 2016-04-25
     * @return string 视图内容
     */
    public function actionIndex() {
        $view = "index";
        return $this->render($view);
    }

    /**
     * 生成 sitemap 操作
     * @author gaoqing
     * @date 2016-04-25
     * @return string json数据
     */
    public function actionGenerate() {
        $name = $this->helpGparam('name', '');
        $where = $this->helpGparam('where', 'pc'); // jb || wapjb || wap_baidu
        $this->_ownership = (strpos($where, 'wap') !== false) ? 'wap' : 'pc'; // pc || wap
        $this->_baidu = (strpos($where, 'baidu') !== false) ? true : false; //baidu
        $method = $name . 'Sitemap';

        $return = $this->$method();

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function diseasehtmlSitemap() {
        $this->disableLayout();

        $departmentObj = new Department();
        $disease = new Disease();
        $symptom = new Symptom();

        //1、科室查询
        $departments = Department::find()->asArray()->all();
        $departmentsMap = [];
        //查询出所有一级科室
        foreach ($departments as $k => $v) {
            if ($v['level'] == 1) {
                $departmentsMap[$v['id']]['level1'] = $v;
            }
        }
        //查询出所有二级科室
        foreach ($departments as $k => $v) {
            foreach ($departmentsMap as $kk => $vv) {
                if ($v['class_level1'] == $kk && (int) $v['id'] !== $kk) {
                    $departmentsMap[$kk]['level2'][] = $v;
                }
            }
        }
        $model['departments'] = $departmentsMap;

        //2、疾病查询
        //根据一级科室查询该科室下所有疾病
        foreach ($departmentsMap as $k => $v) {
            $level1 = $v['level1'];
            $diseaseMap[$k]['department'] = $level1;
            $diseaseMap[$k]['disease'] = $disease->getDiseaseByDepartment($level1['id'], 'class_level1', 0, 8511);
        }
        $model['disease'] = $diseaseMap;
//        print_r($diseaseMap);
//        exit;
        //3、部位查询
        $parts = Part::find()->asArray()->all();
        $partsMap = [];
        //查询出所有一级部位
        foreach ($parts as $k => $v) {
            if ($v['level'] == 1) {
                $partsMap[$v['id']]['level1'] = $v;
            }
        }
        //查询出所有二级科室
        foreach ($parts as $k => $v) {
            foreach ($partsMap as $kk => $vv) {
                if ($v['part_level1'] == $kk && (int) $v['id'] !== $kk) {
                    $partsMap[$kk]['level2'][] = $v;
                }
            }
        }
        $model['parts'] = $partsMap;

        //4、症状查询
        //根据一级部位查询该部位下所有症状
        foreach ($partsMap as $k => $v) {
            $level1 = $v['level1'];
            $symptomMap[$k]['part'] = $level1;
            $symptomMap[$k]['symptom'] = $symptom->getSymptomsByPartid($level1['id'], 'part_level1', 0, 12398);
        }
//        print_r($symptomMap);
//        exit;
        $model['symptom'] = $symptomMap;

        $renderContent = $this->render('diseasehtmlsitemap', [
            'model' => $model
        ]);

        $frontend = \Yii::getAlias("@frontend");
        $sitemapFolder = 'map';
        $fileFolder = $frontend . '/web/' . $sitemapFolder;
        if (!file_exists($fileFolder) || !is_dir($fileFolder)) {
            mkdir($fileFolder, 0755);
        }
        $fileName = 'index.shtml';
        if (file_exists($fileFolder . '/' . $fileName)) {
            unlink($fileFolder . '/' . $fileName);
        }
        if (file_put_contents($fileFolder . '/' . $fileName, $renderContent)) {
            $frontDomain = \Yii::getAlias("@frontdomain");
            return ['flag' => 1, 'url' => $frontDomain . '/' . $sitemapFolder . '/' . $fileName, 'name' => $fileName];
        }
        return [];
    }

    /**
     * 疾病 sitemap
     * @author gaoqing
     * @date 2016-04-25
     * @return array 响应信息
     */
    private function diseaseSitemap() {
        /**
         * <urlset>
         *  <url>
         *  <loc>http://jb.9939.com/article/2009/0327/1.shtml</loc>
         *  <lastmod>﻿2009-03-27</lastmod>
         *  <changefreq>always</changefreq>
         *  <priority>0.6</priority>
         *  </url>
         * </urlset>
         */
        $where = $this->_ownership;
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= $this->_baidu ? '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">' : '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        //判断jb还是wapjb
        $prefix = ($where == 'pc') ? '' : 'wap_';
        //1、生成 疾病 部分的 sitemap
        $diseases = Disease::find()->asArray()->all();
        $sitemap .= $this->setSitemapURL($diseases, $prefix . 'disease');

        //2、生成 症状 部分的 sitemap
        $symptoms = Symptom::find()->asArray()->all();
        $sitemap .= $this->setSitemapURL($symptoms, $prefix . 'symptom');

        //3、生成 科室 部分的 sitemap
        $departments = Department::find()->asArray()->all();
        $sitemap .= $this->setSitemapURL($departments, $prefix . 'department');

        //4、生成 部位 部分的 sitemap
        $parts = Part::find()->asArray()->all();
        $sitemap .= $this->setSitemapURL($parts, $prefix . 'part');

        $sitemap .= '</urlset>';

        //5、生成 sitemap 文件
        if ($where == 'pc') {
            $frontend = \Yii::getAlias("@frontend");
            $frontDomain = \Yii::getAlias("@frontdomain");
        } elseif ($where == 'wap') {
            $frontend = \Yii::getAlias("@wapjb");
            $frontDomain = \Yii::getAlias("@mjb_domain");
        }
//        $frontend = \Yii::getAlias("@frontend");
        $sitemapFolder = 'sitemap';
        $fileFolder = $frontend . '/web/' . $sitemapFolder;
        if (!file_exists($fileFolder) || !is_dir($fileFolder)) {
            mkdir($fileFolder, 0755);
        }
        $fileName = $this->_baidu ? 'diseasebaidusitemap.xml' : 'diseasesitemap.xml';
        if (file_put_contents($fileFolder . '/' . $fileName, $sitemap)) {
//            $frontDomain = \Yii::getAlias("@frontdomain");
            return ['flag' => 1, 'url' => $frontDomain . '/' . $sitemapFolder . '/' . $fileName, 'name' => $fileName];
        }
        return [];
    }

     private function disSymColSitemap() {
        /**
         * <urlset>
         *  <url>
         *  <loc>http://jb.9939.com/gm/jianjie/</loc>
         *  <lastmod>﻿2009-03-27</lastmod>
         *  <changefreq>always</changefreq>
         *  <priority>0.6</priority>
         *  </url>
         * </urlset>
         */
        $this->_changefreq = 'always';
        $this->_priority = '0.6';
        $where = $this->_ownership;
        $flag = 1;
        //目录
        if ($where == 'pc') {
            $frontend = \Yii::getAlias("@frontend");
            $frontDomain = \Yii::getAlias("@frontdomain");
        } elseif ($where == 'wap') {
            $frontend = \Yii::getAlias("@wapjb");
            $frontDomain = \Yii::getAlias("@mjb_domain");
        }
        $sitemapFolder = $this->_baidu ? 'sitemap/sitemapbaidudissymcolindex' : 'sitemap/sitemapdissymcolindex';
        $fileFolder = $frontend . '/web/' . $sitemapFolder;
        if (!file_exists($fileFolder) || !is_dir($fileFolder)) {
            mkdir($fileFolder, 0755, true);
        }

        $type = '';// 疾病 | 症状
        $sitemap_site = $this->getSitemapCount($fileFolder, ['dis_offset' => 0, 'sym_offset' => 0,'max_file_tail'=>0]);

        $dis_offset = $sitemap_site['dis_offset'];
        $dis_obj = new Disease();
        $dis_count = $dis_obj->getCount();
        if ($dis_offset  < $dis_count) {
            $type = 'disease';
            $data = $dis_obj->getDiseaseLimit(['status'=>2],$dis_offset,1000);
            $sitemap_site['dis_offset'] = (int)$dis_offset + count($data);
        } else {
            $type = 'symptom';
            $sym_offset = $sitemap_site['sym_offset'];
            $dis_obj = new Symptom();
            $sym_count = $dis_obj->getCount();
            if ($sym_offset < $sym_count) {
                $data = $dis_obj->getSymptomLimit(['status' => 3], $sym_offset, 2000);
                $sitemap_site['sym_offset'] = (int)$sym_offset + count($data);
                $flag = ($sitemap_site['sym_offset'] == $sym_count) ? 2 : 1;
            }else{
                //无需生成新的数据，返回索引的url
                $res = $this->generateSitemapIndex($fileFolder, $sitemapFolder,'dissym');
                return ['flag' => 2, 'siteindex' => $res['url']];
            }
        }

        //xml
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= $this->_baidu ? '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">' : '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $sitemap .= $this->setDiseaseSymptomSubURL($data, $type);
        $sitemap .= '</urlset>';
        
        $sitemap_site['max_file_tail']++;
        $name_tail = $sitemap_site['max_file_tail'];
        
        //写入计数文件
        $this->setSitemapCount($sitemap_site, $fileFolder);

        $fileName = 'sitemap' . $name_tail . '.xml';
        if (file_put_contents($fileFolder . '/' . $fileName, $sitemap)) {
            $res = $this->generateSitemapIndex($fileFolder, $sitemapFolder,'dissym');
            return ['flag' => $flag, 'url' => $frontDomain . '/' . $sitemapFolder . '/' . $fileName, 'name' => $fileName, 'siteindex' => $res['url']];
        }
        return [];
    }
    
    /**
     * 文章sitemap
     * 
     * <url> 
      <loc>http://m.jb.9939.com/article/2009/0327/22.shtml</loc>
      <mobile:mobile type="mobile"/>
      <lastmod>2009-12-14</lastmod>
      <changefreq>daily</changefreq>
      <priority>0.8</priority>
      </url>
     */
    public function articleSitemap() {
        $this->_changefreq = 'daily';
        $this->_priority = '0.8';
        $where = $this->_ownership;
        //目录
        if ($where == 'pc') {
            $frontend = \Yii::getAlias("@frontend");
            $frontDomain = \Yii::getAlias("@frontdomain");
        } elseif ($where == 'wap') {
            $frontend = \Yii::getAlias("@wapjb");
            $frontDomain = \Yii::getAlias("@mjb_domain");
        }
        $sitemapFolder = $this->_baidu ? 'sitemap/sitemapbaiduaricleindex' : 'sitemap/sitemaparicleindex';
        $fileFolder = $frontend . '/web/' . $sitemapFolder;
        if (!file_exists($fileFolder) || !is_dir($fileFolder)) {
            mkdir($fileFolder, 0755, true);
        }

        //判断jb还是wapjb

        $type = ($where == 'pc') ? 'article' : 'wap_article';
        //文章数据
        $art_obj = new Article();
        $limit = 10000;
        $sitemap_site = $this->getSitemapCount($fileFolder);
        $offset = $sitemap_site['limit'];
        $articles = $art_obj->listByCondition([['status' => 99]], $limit, $offset, 'id ASC');

        $flag = (count($articles) == $limit) ? 1 : 2; //为2时提示已经生成完毕
        //xml
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= $this->_baidu ? '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">' : '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $sitemap .= $this->setSitemapURL($articles, $type);
        $sitemap .= '</urlset>';
        //写入计数文件
        $this->setSitemapCount(['limit' => ((int) $offset + $limit)], $fileFolder);

        $name_tail = intval($offset / 10000 + 1);
        $fileName = 'sitemap' . $name_tail . '.xml';
        if (file_put_contents($fileFolder . '/' . $fileName, $sitemap)) {
            $res = $this->generateSitemapIndex($fileFolder, $sitemapFolder);
            return ['flag' => $flag, 'url' => $frontDomain . '/' . $sitemapFolder . '/' . $fileName, 'name' => $fileName, 'siteindex' => $res['url']];
        }
        return [];
    }

    /**
     *      疾病专题    PC  sitemap
     */
    public function ztSitemap() {
        $ztsitemap = new Ztsitemap();
        $res = $ztsitemap->createartxmlfile();
        return $res;
    }

    /**
     * 生成 sitemap 的 <url> 部分
     * @author gaoqing
     * @date 2016-04-25
     * @param array $datas 数据集
     * @param string $baseURL 当前 url 的基础 url 值
     * @param string $type 当前 url 的类型
     * @return string sitemap 的 <url> 部分
     */
    private function setSitemapURL($datas, $type) {
        $url = '';

        if (isset($datas) && !empty($datas)) {
            foreach ($datas as $data) {
                try {
                    if (!empty($data)) {
                        $url .= '<url>';
                        $baseLoc = $this->getLocURL($type);
                        $loc = $baseLoc;

                        if ($type == 'disease' || $type == 'symptom' || $type == 'wap_disease' || $type == 'wap_symptom') {
                            $loc = $baseLoc . $data['pinyin_initial'] . '/';
                        } elseif ($type == 'wap_article') {
                            $loc = $baseLoc . date("Y/md", $data["inputtime"]) . '/' . $data['id'] . '.shtml';
                        } elseif ($type == 'article_index') {
                            $loc = $data['loc'];
                        } else {
                            $loc = $baseLoc . $data['pinyin'] . '/';
                        }

                        if ($type == 'disease' || $type == 'wap_disease' || $type == 'wap_article') {
                            $date = date('Y-m-d', $data['inputtime']);
                        } elseif ($type == 'article_index') {
                            $date = $data['date'];
                        } else {
                            $date = date('Y-m-d', $data['createtime']);
                        }
                        $url .= '<loc>' . $loc . '</loc>';
                        $url .= $this->_baidu ? '<mobile:mobile type="mobile"/>' : '';
                        $url .= '<lastmod>' . $date . '</lastmod>';
                        $url .= '<changefreq>' . $this->_changefreq . '</changefreq>';
                        $url .= '<priority>' . $this->_priority . '</priority>';
                        $url .= '</url>';
                    }
                } catch (\ErrorException $e) {
                    return [];
                }
            }
        }
        return $url;
    }
    /**
     * 拼接 xml <url> 部分（疾病-症状的简介、病因、预防等）
     * @param type $datas
     * @param type $type
     * @return string
     */
    private function setDiseaseSymptomSubURL($datas, $type) {
        $url = '';
        $dis_sub = ['%s/%s/jianjie/', '%s/%s/zz/', '%s/%s/by/', '%s/%s/yf/', '%s/%s/lcjc/', '%s/%s/jb/', '%s/%s/zl/', '%s/%s/yshl/', '%s/%s/bfz/'];
        $sym_sub = ['%s/zhengzhuang/%s/jianjie/', '%s/zhengzhuang/%s/zzqy/', '%s/zhengzhuang/%s/yufang/', '%s/zhengzhuang/%s/jiancha/', '%s/zhengzhuang/%s/shiliao/'];
        if (isset($datas) && !empty($datas)) {
            foreach ($datas as $data) {
                try {
                    $date = ($type == 'disease') ? date('Y-m-d', $data['inputtime']) : date('Y-m-d', $data['createtime']);
                    $domain = ($this->_ownership == 'pc') ? \Yii::getAlias('@frontdomain') : \Yii::getAlias('@mjb_domain');
                    $type_sub = ($type == 'disease') ? $dis_sub : $sym_sub;
                    foreach ($type_sub as $key => $val) {
                        $loc = sprintf($val, $domain, $data['pinyin_initial']);

                        $url .= '<url>';
                        $url .= '<loc>' . $loc . '</loc>';
                        $url .= $this->_baidu ? '<mobile:mobile type="mobile"/>' : '';
                        $url .= '<lastmod>' . $date . '</lastmod>';
                        $url .= '<changefreq>' . $this->_changefreq . '</changefreq>';
                        $url .= '<priority>' . $this->_priority . '</priority>';
                        $url .= '</url>';
                    }
                } catch (\ErrorException $e) {
                    return [];
                }
            }
        }
        return $url;
    }

    /**
     * 生成索引sitemap
     * @param type $datas
     * @param type $type
     * @return string
     */
    private function setSitemapIndex($datas, $type) {
        $url = '';
        if (isset($datas) && !empty($datas)) {
            ksort($datas);
            foreach ($datas as $data) {
                try {
                    if (!empty($data)) {
                        $url .= '<sitemap>';
                        if ($type == 'article_index') {
                            $loc = $data['loc'];
                            $date = $data['date'];
                        }
                        $url .= '<loc>' . $loc . '</loc>';
                        $url .= '<lastmod>' . $date . '</lastmod>';
                        $url .= '</sitemap>';
                    }
                } catch (\ErrorException $e) {
                    return [];
                }
            }
        }
        return $url;
    }

    /**
     * 文章xml索引文件
     * <sitemapindex>
     * 
     * <sitemap>
     * <loc> http://m.jb.9939.com/sitemap/sitemapbaiduaricleindex/sitemap1.xml
     * </loc>
     * <lastmod>2009-12-14</lastmod>
     * </sitemap>
     * 
     * <sitemap>
     *  <loc> http://m.jb.9939.com/sitemap/sitemapbaiduaricleindex/sitemap2.xml
     * </loc>
     * <lastmod>2009-12-14</lastmod>
     * </sitemap>
     * 
     * </sitemapindex>
     */
    public function generateSitemapIndex($save_sitemap_dir, $maps_path, $source = 'article') {
        $sitemap_files = scandir($save_sitemap_dir);
        $sitemap_index_data = array();
        $where = $this->_ownership;
        if ($where == 'pc') {
            $frontend = \Yii::getAlias("@frontend");
            $frontDomain = \Yii::getAlias("@frontdomain");
        } elseif ($where == 'wap') {
            $frontend = \Yii::getAlias("@wapjb");
            $frontDomain = \Yii::getAlias("@mjb_domain");
        }

        foreach ($sitemap_files as $k => $v) {
            if (!in_array($v, array(".", ".."))) {
                $r_real_path = realpath($save_sitemap_dir . '/' . $v);
                if (is_file($r_real_path) && stripos($v, '.xml')) {
                    $datas[filemtime($r_real_path)] = [
                        'loc' => sprintf('%s/%s/%s', $frontDomain, $maps_path, $v),
                        'date' => "\xEF\xBB\xBF" . date('Y-m-d', fileatime($r_real_path)),
                    ];
                }
            }
        }
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= $this->_baidu ? '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">' : '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $sitemap .= $this->setSitemapIndex($datas, 'article_index');
        $sitemap .= '</sitemapindex>';

        $save_path = $frontend . '/web/sitemap';
        $sitemapFolder = 'sitemap';
        if (!file_exists($save_path) || !is_dir($save_path)) {
            mkdir($save_path, 0755);
        }
        $fileName = $this->_baidu ? 'sitemapbaidu' . $source . 'index.xml' : 'sitemap' . $source . 'index.xml';
        if (file_put_contents($save_path . '/' . $fileName, $sitemap)) {
            return ['url' => $frontDomain . '/' . $sitemapFolder . '/' . $fileName, 'name' => $fileName];
        }
    }

    /**
     * 得到不同类型下的 loc 地址
     * @author gaoqing
     * @date 2016-04-25
     * @param string $type 当前 url 的类型
     * @return string loc 地址
     */
    private function getLocURL($type) {
        $locMap = [
            'disease' => 'http://jb.9939.com/',
            'symptom' => 'http://jb.9939.com/zhengzhuang/',
            'department' => 'http://jb.9939.com/jbzz/',
            'part' => 'http://jb.9939.com/jbzz/',
            'wap_disease' => 'http://m.jb.9939.com/',
            'wap_symptom' => 'http://m.jb.9939.com/zhengzhuang/',
            'wap_department' => 'http://m.jb.9939.com/jbzz/',
            'wap_part' => 'http://m.jb.9939.com/jbzz/',
            'wap_article' => 'http://m.jb.9939.com/article/',
        ];
        return array_key_exists($type, $locMap) ? $locMap[$type] : '';
    }

    /**
     * 文章sitemap 每次生成1000条 保存条数和偏移位置
     *  [offset=>1000]
     */
    private function getSitemapCount($fileFolder,$default = []) {
//        $backend = \Yii::getAlias("@wapjb");
//        $fileFolder = $backend . '/web/sitemap/article';
        $fileName = $fileFolder . '/data_max_articleid.php';
        if (!file_exists($fileName)) {
            $this->setSitemapCount($default, $fileFolder);
        }
        $contents = file_get_contents($fileName);
        return json_decode($contents, true);
    }

    private function setSitemapCount($sitemap_count = [], $fileFolder) {
//        $backend = \Yii::getAlias("@wapjb");
//        $fileFolder = $backend . '/web/sitemap/article';
        $fileName = $fileFolder . '/data_max_articleid.php';
        if (!file_exists($fileFolder) || !is_dir($fileFolder)) {
            mkdir($fileFolder, 0755);
        }
        if (count($sitemap_count)) {
            $count = $this->getSitemapCount($fileFolder);
            $sitemap_count = array_merge($count, $sitemap_count);
        } else {
            $sitemap_count = ['limit' => 0];
        }
        if (file_put_contents($fileName, json_encode($sitemap_count))) {
            return true;
        }
    }

}
