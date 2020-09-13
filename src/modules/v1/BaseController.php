<?php
namespace app\modules\v1;

use \Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Response;

abstract class BaseController extends ActiveController
{
    /**
     * @var string the search model class name. This property must be set.
     */
    public $modelSearchClass;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],
                // Allow only headers 'X-Wsse'
                //'Access-Control-Request-Headers' => ['X-Wsse'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];

        if(YII_ENV !== 'dev') {
            $behaviors['httpCacheIndex'] = [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index'],
                'lastModified' => function ($action, $params) {
                    $time = (new \yii\db\Query())
                        ->from((new $this->modelClass)->tableName())
                        ->max('updated_at');
                    return strtotime($time);
                },
            ];

            $behaviors['httpCacheView'] = [
                'class' => 'yii\filters\HttpCache',
                'only' => ['view'],
                'lastModified' => function ($action, $params) {
                    $id = Yii::$app->request->get('id');
                    $time = $this->modelClass::findOne($id)->updated_at;
                    return strtotime($time);
                },
            ];
        }

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return (new $this->modelSearchClass())->setParams(Yii::$app->request->queryParams)->search();
    }
}