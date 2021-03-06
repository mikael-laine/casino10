<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $image_url
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class Category extends ActiveRecord
{
    const STATUS_DELETED = false;
    const STATUS_ACTIVE = true;

    public $temp_image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','meta_keywords', 'meta_description'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description', 'image_url', 'meta_keywords', 'meta_description'], 'string'],
            [['temp_image'], 'safe'],
            [['temp_image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'slug' => 'Slug',
            'image_url' => 'Image',
            'temp_image' => 'Image',
            'meta_keywords' => 'SEO Keywords',
            'meta_description' => 'SEO description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Finds category by title
     *
     * @param string $title
     * @return static|null
     */
    public static function findByCategorytitle($title)
    {
        return static::findOne(['title' => $title, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCateComps()
    {
        return $this->hasMany(CateComp::className(), ['category_id' => 'id']);
    }

    /**
     * @return url
     */
    public function getRoute()
    {
        return ['category/slug', 'slug' => $this->slug];
    }
}
