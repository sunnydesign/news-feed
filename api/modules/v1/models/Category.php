<?php
namespace api\modules\v1\models;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\Link;
use yii\web\Linkable;

/**
 * Category Model
 */
class Category extends ActiveRecord implements Linkable
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
    {
        return '{{%categories}}';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
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
            'parent_id',
            'created_at',
            'childs',
        ];
    }

    public function extraFields()
    {
        return [
            'parent',
            'articles'
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['category/view', 'id' => $this->id], true),
        ];
    }

    public function getChilds()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('{{%articleCategories}}', ['category_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value'      => new Expression('NOW()'),
            ],
        ];
    }
}
