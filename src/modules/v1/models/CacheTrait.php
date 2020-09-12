<?php
namespace app\modules\v1\models;

use \Yii;
use yii\caching\DbDependency;
use yii\data\ActiveDataProvider;

trait CacheTrait
{
    /**
     * @param ActiveDataProvider $dataProvider
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function checkCache($dataProvider)
    {
        if(YII_ENV === 'dev') {
            return $dataProvider;
        }

        $dependency = new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM ' . parent::tableName()]);
        Yii::$app->db->cache(
            function () use ($dataProvider)
            {
                return $dataProvider->prepare();
            },
            600,
            $dependency
        );

        return $dataProvider;
    }
}