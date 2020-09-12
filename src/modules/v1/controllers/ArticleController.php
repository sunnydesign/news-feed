<?php
namespace app\modules\v1\controllers;

use app\modules\v1\BaseController;

/**
 * Article Controller API
 */
class ArticleController extends BaseController
{
    public $modelClass = 'app\modules\v1\models\Article';
    public $modelSearchClass = 'app\modules\v1\models\ArticleSearch';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}