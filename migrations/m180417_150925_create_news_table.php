<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180417_150925_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'url' => $this->text(),
            'urlToImage' => $this->text()->null(),
            'source_id' => $this->string(255)->null(),
            'source_name' => $this->text()->null(),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}
