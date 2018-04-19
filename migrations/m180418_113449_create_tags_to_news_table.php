<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags_to_news`.
 */
class m180418_113449_create_tags_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tags_to_news', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()->notNull(),
            'news_id' => $this->integer()->notNull(),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-tag-tag_id',
            'tags_to_news',
            'tag_id'
        );

        // add foreign key for table `tags`
        $this->addForeignKey(
            'fk-tag-tag_id',
            'tags_to_news',
            'tag_id',
            'tags',
            'id',
            'CASCADE'
        );

        // creates index for column `news_id`
        $this->createIndex(
            'idx-post-news_id',
            'tags_to_news',
            'news_id'
        );

        // add foreign key for table `news`
        $this->addForeignKey(
            'fk-post-news_id',
            'tags_to_news',
            'news_id',
            'news',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `tags`
        $this->dropForeignKey(
            'fk-tag-tag_id',
            'tags_to_news'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-tag-tag_id',
            'tags_to_news'
        );

        // drops foreign key for table `news`
        $this->dropForeignKey(
            'fk-post-news_id',
            'tags_to_news'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            'idx-post-news_id',
            'tags_to_news'
        );

        $this->dropTable('tags_to_news');
    }
}
