<?php
namespace app\modules\v1\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * Article Model
 */
class Article extends ActiveRecord implements Linkable
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%articles}}';
	}

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'string', 'length' => 255],
            [['parent_id'], 'integer'],
            [['created_at', 'updated_at'], 'date']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'content',
            'categories',
            'created_at'
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['article/view', 'id' => $this->id], true),
        ];
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('{{%article_categories}}', ['article_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
