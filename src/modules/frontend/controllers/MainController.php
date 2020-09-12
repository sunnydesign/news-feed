<?php

namespace app\modules\frontend\controllers;

use app\modules\v1\models\Article;
use app\modules\v1\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Main Controller
 */
class MainController extends Controller
{
    public function actionIndex()
    {
        return $this->render('main');
    }


    /*
    public function actionIndex()
    {
        //$currentCategory = Category::find()->one();
        $articlesQuery = Article::find();
            //->joinWith(['categories'])
            //->where(['categories.id' => 5]);

        $dataProvider = new ActiveDataProvider([
            'query' => $articlesQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
        ]);

        $data = [
            'currentCategory' => $currentCategory = Category::find()->one(),
            'categories' => Category::find()->hierarchically()->all(),
            'articles' => $currentCategory->articles,
            'articlesDataProvider' => $dataProvider
        ];
        //var_dump(count($data['categories']));die;
        return $this->render('index', $data);
    }
    */
}