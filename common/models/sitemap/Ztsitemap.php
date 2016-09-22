<?php

namespace common\models\sitemap;

use common\models\KeyWords;
use common\models\sitemap\CreateXml;

class Ztsitemap {

    private $url;

    public function __construct() {
        $this->url = \Yii::getAlias("@jb_domain");
    }

    public function createartxmlfile() {
        $key_obj = new KeyWords();
        $top_art_list = $key_obj->List_All('typeid = 99', 'id desc', 1, 0);
        $max_article_id = $top_art_list[0]['id'];
        $sitemap_path = 'sitemap';
        $maps_path = $sitemap_path . DIRECTORY_SEPARATOR . 'kwmaps';
        $save_sitemap_dir = \Yii::getAlias("@frontend") . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $maps_path;

        if (!file_exists($save_sitemap_dir)) {
            mkdir($save_sitemap_dir, 0777, true);
        }
        $data_max_articleid = 0;
        $max_file_index = 0;
        $data_max_articleid_file = $save_sitemap_dir . DIRECTORY_SEPARATOR . 'data_max_articleid.php';
        if (is_file($data_max_articleid_file)) {
            $content = file_get_contents($data_max_articleid_file);
            $data = unserialize($content);
            $data_max_articleid = $data['max_articleid']; //同缓存文件中读取上次的最大文章ID
            $max_file_index = $data['max_file_index'];
        }
        if ($data_max_articleid >= $max_article_id) {
            $sitemap_index_filename = sprintf('sitemapkw%s.xml', 'index');
            return [
                'flag' => 2,
                'siteindex' => $this->url . DIRECTORY_SEPARATOR . $sitemap_path . DIRECTORY_SEPARATOR . $sitemap_index_filename,
            ];
            exit;
        }
        $max_diff = 10000; //每个文件放的记录数
        $start_article_id = $data_max_articleid;
        $file_index = $max_file_index + 1;
        $return_info = array();
        $top_art_list = $key_obj->List_All("id>{$start_article_id} and typeid = 99", 'id asc', 10000, 0);
        $max_article_id = $top_art_list[count($top_art_list) - 1]['id'];
        //$max_article_id = 1257273;//$start_article_id+$max_diff;
        while ($start_article_id < $max_article_id) {
            if ($start_article_id >= $max_article_id) {
                break;
            }
            $end_article_id = $start_article_id + $max_diff;
            $art_list = array();
            $this->getCreateData($start_article_id, $max_article_id, $max_diff, $art_list);
            $data = array();
            $total_record = count($art_list);
            if ($total_record > 0) {
                $end_article_id = $art_list[$total_record - 1]['id'];
            }
            foreach ($art_list as $k => $v) {
                $node = array();
                $node['loc'] = $this->getUrl($v['pinyin']);
                $node['lastmod'] = "\xEF\xBB\xBF" . date('Y-m-d', $v['createtime']);
                $node['changefreq'] = 'always';
                $node['priority'] = '0.6';
                $node_parent = array('url' => $node);
                $data[] = $node_parent;
            }
            if (count($data) > 0) {
                $filename = sprintf('sitemap%d.xml', $file_index);
                $root_name = 'urlset';
                $return_save_info = CreateXml::createxmlfile($data, $filename, $save_sitemap_dir, $root_name);

                if ($return_save_info) {
                    $return_info['url'] = sprintf($this->url . '/%s/%s', $maps_path, $filename);
                }
                $file_index++;
            }
            $start_article_id = $end_article_id;
        }

        $max_article_id = $start_article_id;
        if (count($return_info) >= 0) {
            $sitemap_files = scandir($save_sitemap_dir);
            $sitemap_index_data = array();
            foreach ($sitemap_files as $k => $v) {
                if (!in_array($v, array(".", ".."))) {
                    $r_real_path = realpath($save_sitemap_dir . '/' . $v);
                    if (is_file($r_real_path) && stripos($v, '.xml')) {
                        $xml_url = sprintf($this->url . '/%s/%s', $maps_path, $v);
                        $node = array();
                        $node['loc'] = $xml_url;
                        $node['lastmod'] = "\xEF\xBB\xBF" . date('Y-m-d', fileatime($r_real_path));
                        $node_parent = array('sitemap' => $node);
                        $sitemap_index_data[] = $node_parent;
                    }
                }
            }

            $save_sitemapindex_path = dirname($save_sitemap_dir);
            $sitemap_index_filename = sprintf('sitemapkw%s.xml', 'index');
            $root_name = 'sitemapindex';
            $root_attr = array('xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9/');
            $return_save_info = CreateXml::createxmlfile($sitemap_index_data, $sitemap_index_filename, $save_sitemapindex_path, $root_name, $root_attr);

            if ($return_save_info) {
                $return_info['siteindex'] = sprintf($this->url . '/%s/%s', $sitemap_path, $sitemap_index_filename);
                $return_info['flag'] = 1;
                $arr = array('max_articleid' => $max_article_id, 'max_file_index' => $file_index - 1, 'addtime' => time());
                $content = serialize($arr);
                file_put_contents($data_max_articleid_file, $content);
                return $return_info;
            }
        }
    }

    private function getCreateData($start_article_id = 0, $max_article_id = 0, $max_diff = 10000, &$art_list = array()) {
        $total_record = count($art_list);
        if ($total_record <= $max_diff && $start_article_id <= $max_article_id) {
            $kw_obj = new KeyWords();
            $end_article_id = $start_article_id + $max_diff;
//            $where = "id > '{$start_article_id}' and id < '{$end_article_id}' and typeid = 99 ";
            $where = "id > '{$start_article_id}' and typeid = 99 ";
            $offset = 0;
            $count = $max_diff - $total_record;
            $tmp_art_list = $kw_obj->List_All($where, 'id asc', $count, $offset);
            if ($count > 0) {
                $tmp_art_list = $kw_obj->List_All($where, 'id asc', $count, $offset);
                if ($tmp_art_list) {
                    $art_list = array_merge($art_list, $tmp_art_list);
                    $total_record = count($art_list);
                    $start_article_id = $art_list[$total_record - 1]['id'];
                } else {
                    $start_article_id = $end_article_id;
                    $total_record = count($art_list);
                }
                $this->getCreateData($start_article_id, $max_article_id, $max_diff, $art_list);
            }
        }
    }

    private function getUrl($val) {
        $url = $this->url . "/so/";
        if (isset($val) && !empty($val)) {
            $url .= $val . DIRECTORY_SEPARATOR;
        }
        return $url;
    }

}
