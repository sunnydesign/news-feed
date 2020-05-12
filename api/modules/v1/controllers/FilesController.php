<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Files;
use yii\rest\Controller;
use yii\web\Response;
use Yii;
use yii\web\HttpException;

/**
 * Files Controller API
 */
class FilesController extends Controller
{
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    public function actionIndex()
    {
        return (new Files(\Yii::$app->params['upload']))->getAll();
        //return $this->getFilesList();
    }

    public function actionView($id)
    {
        $fileInfo = (new Files(\Yii::$app->params['upload']))->getOne($id);

        if(!$fileInfo) {
            throw new HttpException(404, 'File not found');
        }

        Yii::$app->response->format = Response::FORMAT_RAW;

        $f = file_get_contents($fileInfo['realpath']);

        return Yii::$app->response->sendFile(
            $fileInfo['realpath'], null, ['mimeType' => 'application/octet-stream']
        );
    }

    public function actionCreate()
    {
        return ['upload_dir' => Yii::$app->params['upload']];
    }

    public function actionUpdate()
    {
        return ['upload_dir' => Yii::$app->params['upload']];
    }
    /*
    public function actionDelete()
    {
        return ['upload_dir' => Yii::$app->params['upload']];
    }
    */
    public function actionOptions()
    {
        return ['upload_dir' => Yii::$app->params['upload']];
    }
}