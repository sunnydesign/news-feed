<?php

namespace api\modules\v1\controllers;

use api\modules\v1\helpers\Pagination;
use api\modules\v1\models\Files;
use yii\rest\Controller;
use yii\web\Response;
use Yii;
use yii\web\HttpException;
use yii\web\UploadedFile;

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
        $pagination = new Pagination(Yii::$app->request->get('page'));

        return (new Files(\Yii::$app->params['upload'], $pagination))->getAll();
    }

    public function actionView($id)
    {
        $page = (int) ($id / Pagination::LIMIT) + 1;
        $pagination = new Pagination($page);
        $fileInfo = (new Files(\Yii::$app->params['upload'], $pagination))->getOne($id);

        if(!$fileInfo) {
            throw new HttpException(404, 'File not found');
        }

        Yii::$app->response->format = Response::FORMAT_RAW;

        return Yii::$app->response->sendFile(
            $fileInfo['realpath'], null, ['mimeType' => 'application/octet-stream']
        );
    }

    public function actionCreate()
    {
        $putdata = fopen("php://input", "r");
/*
        $path = \yii::getAlias('@webroot')."/upload/myputfile.ext";

        $fp = fopen($path, "w");

        while ($data = fread($putdata, 1024))
            fwrite($fp, $data);

        fclose($fp);
        fclose($putdata);
        */
        //$body = Yii::$app->request->getBodyParams();
        //$file = UploadedFile::getInstanceByName('photo');
        var_dump($putdata); die;
        return ['upload_dir' => Yii::$app->params['upload'], 'file' => $file];
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