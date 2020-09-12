<?php
namespace app\modules\v1\models;

use yii\data\ActiveDataProvider;

/**
 * CategorySearch Model
 */
class CategorySearch extends Category
{
    use CheckParamsTrait;
    use CacheTrait;

    /**
     * @var array
     */
    public $params;

    /**
     * @var string
     */
    public $parent;

    /**
     * @param array $params
     * @return CategorySearch $this
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
            [['parent'], 'integer'],
        ];
    }

    /**
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search()
    {
        $this->checkParams();

        $query = parent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($this->params, '') && $this->validate())) {
            return $this->checkCache($dataProvider);
        }

        $query->andFilterWhere(['parent_id' => $this->parent]);

        return $dataProvider;
    }
}
