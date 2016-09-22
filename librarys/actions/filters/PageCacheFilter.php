<?php

namespace librarys\actions\filters;

use Yii;
use yii\caching\Cache;
use yii\di\Instance;
use yii\web\Response;
/**
 * 
 */
class PageCacheFilter extends \yii\filters\PageCache {
    
    /**
     * @var string the directory to store cache files. You may use path alias here.
     * If not set, it will use the "cache" subdirectory under the application runtime path.
     */
    public $cachePath = '@runtime/cache';
    public function beforeAction($action) {
        if (!$this->enabled) {
            return true;
        }

        $this->cache = Instance::ensure($this->cache, Cache::className());
        $this->cache->cachePath = Yii::getAlias( $this->cachePath).'/'.$action->getUniqueId();
        
        if (is_array($this->dependency)) {
            $this->dependency = Yii::createObject($this->dependency);
        }

        $properties = [];
        foreach (['cache', 'duration', 'dependency', 'variations'] as $name) {
            $properties[$name] = $this->$name;
        }
        $id = $this->varyByRoute ? $action->getUniqueId() : __CLASS__;
        $response = Yii::$app->getResponse();
        ob_start();
        ob_implicit_flush(false);
        if ($this->view->beginCache($id, $properties)) {
            $response->on(Response::EVENT_AFTER_SEND, [$this, 'cacheResponse']);
            return true;
        } else {
            $data = $this->cache->get($this->calculateCacheKey());
            if (is_array($data)) {
                $this->restoreResponse($response, $data);
            }
            $response->content = ob_get_clean();
            return false;
        }
    }
}
