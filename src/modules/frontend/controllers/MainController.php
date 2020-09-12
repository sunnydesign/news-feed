<?php
namespace app\modules\frontend\controllers;

use yii\web\Controller;

/**
 * Main Controller
 */
class MainController extends Controller
{
    public $layout = false;

    public function actionIndex()
    {
        return $this->render('index');
    }
}