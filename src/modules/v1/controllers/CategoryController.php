<?php
namespace app\modules\v1\controllers;

use app\modules\v1\BaseController;

/**
 * Category Controller API
 */
class CategoryController extends BaseController
{
    public $modelClass = 'app\modules\v1\models\Category';
    public $modelSearchClass = 'app\modules\v1\models\CategorySearch';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}