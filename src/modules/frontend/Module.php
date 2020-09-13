<?php

namespace app\modules\frontend;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\frontend\controllers';

    public function init()
    {
        parent::init();
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }
}
