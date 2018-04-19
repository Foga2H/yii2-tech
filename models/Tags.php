<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property string $tag
 * @property string $updated_at
 * @property string $created_at
 *
 * @property TagsToNews[] $tagsToNews
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsToNews()
    {
        return $this->hasMany(TagsToNews::className(), ['tag_id' => 'id']);
    }

    public function getTagsCount()
    {
        $tagsHistory = TagsHistory::find()->where(['=', 'tag_id', $this->id])->all();
        $count = 0;

        foreach($tagsHistory as $item) {
            $count = ($item->count+$count);
        }

        return $count;
    }

    public static function createTag($name)
    {
        $tag = new Tags();
        $tag->tag = $name;
        $tag->save();

        TagsHistory::addHistory($tag);

        return $tag;
    }

    public static function generateTags(array $news)
    {
        $unnecessaryTags = array(
            ',', '.', ':', ";", '!', '?', "'", '"', '-', '+'
        );

        $blockedTags = [];

        foreach(TagsBlacklist::find()->all() as $blockedTag)
        {
            $blockedTags[] = $blockedTag->tag;
        }

        foreach($news as $post) {
            $tags = explode(' ', $post->description);

            foreach($tags as $tag) {
                if(!in_array($tag, $unnecessaryTags) && !in_array($tag, $blockedTags)) {
                    $tag = preg_replace ("~[^a-z|а-я|0-9|\-|.]*~is","", $tag);
                    $tag = mb_convert_encoding($tag, "UTF-8");

                    if(strlen($tag) > 2) {
                        $tagItem = static::find()->where(['tag' => $tag])->one();

                        if(!$tagItem) {
                            $tagItem = self::createTag($tag);
                        } else {
                            TagsHistory::addHistory($tagItem);
                        }

                        TagsToNews::createTagsToNews($tagItem, $post);
                    }
                }
            }
        }
    }
}
