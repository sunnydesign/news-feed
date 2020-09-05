<?php
namespace api\modules\v1\models;

use yii\data\ActiveDataProvider;

/**
 * ArticleSearch Model
 */
class ArticleSearch extends Article
{
    use ChildsTrait;

    public $category;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = parent::find()
            ->joinWith(['categories']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            // todo: error wrong params
            return $dataProvider;
        }

        $query->andFilterWhere(['categories.id' => $this->getChilds(
            [
                'table' => '{{%categories}}',
                'key' => 'id',
                'refKey' => 'parent_id'
            ],
            $this->category
        )]);

        return $dataProvider;
    }
}
