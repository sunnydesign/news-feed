<?php
namespace app\modules\v1\models;

use yii\data\ActiveDataProvider;

/**
 * ArticleSearch Model
 */
class ArticleSearch extends Article
{
    use ChildsTrait;
    use CheckParamsTrait;
    use CacheTrait;

    const PROTECTED_PARAMS = ['page', 'fields', 'expand'];

    /**
     * @var array
     */
    public $params;

    /**
     * @var string
     */
    public $category;

    /**
     * @param array $params
     * @return ArticleSearch $this
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
        ];
    }

    /**
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search()
    {
        $this->checkParams();

        $query = parent::find()
            ->joinWith(['categories']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($this->params, '') && $this->validate())) {
            return $this->checkCache($dataProvider);
        }

        $query->andFilterWhere(['categories.id' => $this->findChildIds(
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
