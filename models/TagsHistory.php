<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags_history".
 *
 * @property int $id
 * @property string $tag_id
 * @property int $count
 * @property string $updated_at
 * @property string $created_at
 */
class TagsHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id'], 'required'],
            [['count'], 'default', 'value' => null],
            [['count'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['tag_id'], 'integer'],
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
            'count' => 'Count',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public static function addHistory($tag)
    {
        $now = new \DateTime();

        $historyToday = static::find()->where("DATE(created_at) = '" . $now->format('Y-m-d') . "'")
            ->andWhere(['=', 'tag_id', $tag->id])->one();

        if(is_null($historyToday)) {
            $history = new TagsHistory();
            $history->tag_id = $tag->id;
            $history->count = 1;
            $history->save();

            return $history;
        }

        $historyToday->count = ($historyToday->count+1);
        $historyToday->save();

        return $historyToday;
    }
}
