<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags_blacklist".
 *
 * @property int $id
 * @property string $tag
 * @property string $updated_at
 * @property string $created_at
 */
class TagsBlacklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_blacklist';
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
}
