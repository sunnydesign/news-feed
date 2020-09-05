<?php

namespace api\modules\v1\controllers;

use api\modules\v1\BaseController;

/**
 * Article Controller API
 */
class ArticleController extends BaseController
{
    public $modelClass = 'api\modules\v1\models\Article';
    public $modelSearchClass = 'api\modules\v1\models\ArticleSearch';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}