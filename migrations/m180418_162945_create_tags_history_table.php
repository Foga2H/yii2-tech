<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags_history`.
 */
class m180418_162945_create_tags_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tags_history', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tags_history');
    }
}
