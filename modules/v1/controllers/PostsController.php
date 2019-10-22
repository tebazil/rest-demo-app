<?php

namespace app\modules\v1\controllers;


use app\components\BaseRestController;
use app\components\RecordNotFoundException;
use yii\db\Exception;
use yii\mongodb\Connection;
use yii\mongodb\Query;
use yii\mongodb\validators\MongoIdValidator;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class PostsController extends BaseRestController
{
    public function actionIndex($cityId, $userId = null, int $offset = null, int $limit = null)
    {
//        var_dump($limit); exit();
        $query = new Query();
        $ret = $query->from('posts')->where(['citySlug'=>$cityId])->andFilterWhere(['userId' =>$userId])->offset($offset)->limit($limit)->all();
        return $ret;
    }

    public function actionView($id)
    {
        $this->ensureCorrectMongoId($id);
        $query = new Query();
        $ret = $query->from('posts')->where(['_id'=> $id])->one();
        if(!$ret) {
            throw new RecordNotFoundException();
        }
        return $ret;
    }

    protected function verbs()
    {
        return [
            'index'  => ['GET'],
            'view'   => ['GET'],
        ];
    }

    private function ensureCorrectMongoId($id) {
        if(!(new MongoIdValidator())->validate($id)) {
           throw new RecordNotFoundException("Incorrect Id");
        };
    }


}
