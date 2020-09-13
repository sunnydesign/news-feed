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

    const PROTECTED_PARAMS = ['page', 'fields', 'expand'];

    /**
     * @var array
     */
    public $params;

    /**
     * @var string
     */
    public $parentCategory;

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
            [['parentCategory'], 'integer'],
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

        $query->andFilterWhere(['parent_id' => $this->parentCategory]);

        return $dataProvider;
    }
}
