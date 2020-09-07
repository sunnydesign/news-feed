<?php
namespace app\modules\v1\models;

use yii\data\ActiveDataProvider;

/**
 * CategorySearch Model
 */
class CategorySearch extends Category
{
    public $parent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = parent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            // todo: error wrong params
            return $dataProvider;
        }

        $query->andFilterWhere(['parent_id' => $this->parent]);

        return $dataProvider;
    }
}
