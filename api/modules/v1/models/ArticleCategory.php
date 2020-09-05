<?php
namespace api\modules\v1\models;
use yii\db\ActiveRecord;

/**
 * ArticleCategory Model
 */
class ArticleCategory extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%articleCategories}}';
	}

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['article_id'], 'integer'],
            [['category_id'], 'integer'],
        ];
    }
}
