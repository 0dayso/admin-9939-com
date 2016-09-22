<?php
/**
 * @version 0.0.0.1
 */

namespace backend\modules\basedata\controllers;


use common\models\Comment;
use librarys\controllers\backend\BackController;

class CommentController extends BackController
{
    public function init()
    {
        parent::init();
    }

    public function actionUpdate(){
        $values = $this->getParams();
        $values['content'] = trim($values['content'], ',');
        $id = $values['id'];
        unset($values['id']);

        $defaults = [
            'userid' => $this->user->id,
            'username' => $this->user->login_name,
            'updatetime' => time(),
        ];

        $comment = new Comment();
        $flag = $comment->updateComm(array_merge($values, $defaults), ['id' => $id]);
        if ($flag){
            $this->redirect('/basedata/comment/index');
        }
    }

    public function actionInsert(){
        $values = $this->getParams();
        $values['content'] = trim($values['content'], ',');

        $defaults = [
            'userid' => $this->user->id,
            'username' => $this->user->login_name,
            'addtime' => time(),
            'updatetime' => time(),
            'status' => 1,
        ];

        $comment = new Comment();
        $flag = $comment->insertComm(array_merge($values, $defaults));
        if ($flag){
            $this->redirect('/basedata/comment/index');
        }
    }

    public function actionEdit(){
        $id = $this->helpGquery('id', '0');

        $comm = new Comment();
        $comment = $comm->getComment(['id' => $id]);
        $comment['content_arr'] = explode(',', $comment['content']);

        $params = ['comment' => $comment];
        return $this->render('edit', $params);
    }

    public function actionAdd(){
        return $this->render('add');
    }

    public function actionIndex(){
        $page = $this->helpGquery('page', 1);
        $size = 9;
        $offset = ($page - 1) * $size;

        $comment = new Comment();
        $values = $comment->getComments(null, $offset, $size, null);

        $comments = $values['list'];
        array_walk($comments, function (&$value, $key){
            $value['addtime'] = date('Y-m-d H:i', $value['addtime']);
        });
        $total = $values['total'];
        $pageHTML = $this->getPageHTML($page, $size, $total);

        $params = ['comments' => $comments, 'pageHTML' => $pageHTML];

        return $this->render('index', $params);
    }

    public function getPageHTML($page, $size, $count){
        $prePage = 1;
        if ($page > 1){
            $prePage = $page - 1;
        }
        $pageHTML = '<a href="/basedata/comment/index?page='. $prePage .'" class="hko kos" data-id = "pre">&lt;&lt;</a>';
        $first = 1;
        $paging = ($size + 1) / 2;
        $floor = ($size - 1) / 2;
        $total = ceil($count / $size);
        if($page > $paging){
            $first = $page - $floor;
        }
        for($i = 0; $i < $size; $i++){
            $currNum = $first + $i;
            if($currNum > $total){
                break;
            }
            $style = $page == $currNum ? "class='curt'" : "";
            $dataValue = $currNum == $total ? 'data-value = "end"' : '';
            $pageHTML .= '<a href="/basedata/comment/index?page='. $currNum .'" '. $style .' data-id = "page" '. $dataValue .' >'. $currNum .'</a>';
        }
        if($size < $total){
            $pageHTML .= '<span>...</span>';
            $pageHTML .= '<a href="/basedata/comment/index?page='. $total .'" data-id = "page" data-value = "end">'. $total .'</a>';
        }
        $nextPage = $total;
        if ($page < $total){
            $nextPage = $page + 1;
        }
        $pageHTML .= '<a href="/basedata/comment/index?page='. $nextPage .'" class="hko" data-id = "next">&gt;&gt;</a>';
        return $pageHTML;
    }

}