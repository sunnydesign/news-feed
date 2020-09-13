<?php
namespace app\modules\v1\models;

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
		return '{{%article_categories}}';
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'integer'],
            [['category_id'], 'integer'],
        ];
    }
}
