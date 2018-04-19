<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags_blacklist`.
 */
class m180418_150658_create_tags_blacklist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tags_blacklist', [
            'id' => $this->primaryKey(),
            'tag' => $this->string()->notNull(),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tags_blacklist');
    }
}
