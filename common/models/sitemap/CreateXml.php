<?php
namespace common\models\sitemap;
use DOMDocument;
class CreateXml {
     /**
     * 
     * @param array $data
     * @param string $filename
     * @param string $save_path
     * @param string $root_name
     * @return boolean
     */
    public static function createxmlfile($data,$filename='',$save_path='',$root_name='Root',$root_attr = array()){
        $dom = new DOMDocument('1.0', 'UTF-8');
        $root = $dom->createElement($root_name);
        if(count($root_attr)>0){
            foreach($root_attr as $k=>$v){
                $root->setAttribute($k, $v);
            }
        }
        $dom->appendChild($root);
        foreach($data as $k=>$v){
            self::createnode($dom, $root, $v);
        }
        
        $save_file_name = empty($filename)? sprintf("%d.xml",time()):$filename;
        $base_save_path = $save_path;
        if(!file_exists($base_save_path)){
            mkdir($base_save_path,0777,true);
        }
        $save_path = $base_save_path.DIRECTORY_SEPARATOR.$save_file_name;
        $flag = $dom->save($save_path);
        if($flag){
            return array('save_path'=>$save_path,'file_name'=>$save_file_name);
        }else{
            return false;
        }
    }
    
    private static function createnode($dom,$item_article,$data){
        foreach($data as $k=>$v){
            if(is_numeric($k)){
                self::createnode($dom,$item_article,$v);
            }else{
                $child_node = $dom->createElement($k);
                $item_article->appendChild($child_node);
                if(is_array($v)){
                    self::createnode($dom,$child_node,$v);
                }else{
                    $child_node_text_value = $dom->createTextNode($v);
                    $child_node->appendChild($child_node_text_value);
                }
            }
        }
    }
}
