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
        $storage = new \Upload\Storage\FileSystem(\Yii::$app->params['upload']);
        $file = new \Upload\File('0', $storage);

        $file->addValidations(array(
            new \Upload\Validation\Size(\Yii::$app->params['sizeLimit'])
        ));

        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'realpath'   => $file->getRealPath(),
        );

        try {
            $file->upload();
        } catch (\Exception $e) {
            $errors = $file->getErrors();
        }

        /*
        if(isset($_FILES) && isset($_FILES[0])) {
            $file = $_FILES[0];
        }
        */
        return ['upload_dir' => Yii::$app->params['upload'], 'file' => $data];
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