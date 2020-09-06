<?php

namespace api\modules\frontend\controllers;

use api\modules\v1\models\Category;
use yii\web\Controller;

/**
 * Main Controller
 */
class MainController extends Controller
{
    public function actionIndex()
    {
        $data = [
            'currentCategory' => $currentCategory = Category::find()->one(),
            'categories' => Category::find()->hierarchically()->all(),
            'articles' => $currentCategory->articles
        ];
        //var_dump(count($data['categories']));die;
        return $this->render('index', $data);
    }
}