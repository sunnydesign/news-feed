<?php

namespace api\modules\v1\controllers;

use api\modules\v1\BaseController;

/**
 * Category Controller API
 */
class CategoryController extends BaseController
{
    public $modelClass = 'api\modules\v1\models\Category';
    public $modelSearchClass = 'api\modules\v1\models\CategorySearch';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}