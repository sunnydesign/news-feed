<?php
namespace app\modules\v1\models;

use \yii\db\ActiveQuery;

/**
 * CategorySearch Model
 */
class CategoryQuery extends ActiveQuery
{
    public function hierarchically()
    {
        return $this->andWhere('[[parent_id]] IS NULL');
    }
}
