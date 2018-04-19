<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags_to_news".
 *
 * @property int $id
 * @property int $tag_id
 * @property int $news_id
 * @property string $updated_at
 * @property string $created_at
 *
 * @property News $news
 * @property Tags $tag
 */
class TagsToNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_to_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'news_id'], 'required'],
            [['tag_id', 'news_id'], 'default', 'value' => null],
            [['tag_id', 'news_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'news_id' => 'News ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }

    public static function createTagsToNews($tag, $post)
    {
        $tagItem = static::find()->where(['news_id' => $post->id])
            ->andWhere(['=', 'tag_id', $tag->id])->one();

        if(!$tagItem) {
            $tagItem = new static();
            $tagItem->tag_id = $tag->id;
            $tagItem->news_id = $post->id;
            $tagItem->save();
        }

        return $tagItem;
    }
}
