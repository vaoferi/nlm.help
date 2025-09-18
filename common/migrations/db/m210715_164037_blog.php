<?php

use yii\db\Migration;

/**
 * Class m210715_164037_blog
 */
class m210715_164037_blog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'view' => $this->string(),
            'author_id' => $this->integer(),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'published_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey('fk_blog_updated_by', '{{%blog}}', 'updated_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_blog_created_by', '{{%blog}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');


        $this->createTable('{{%blog_lang}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(512),
            'body' => $this->text(),
        ]);

        $this->addForeignKey('fk_blog_lang', '{{%blog_lang}}', 'blog_id', '{{%blog}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%blog_attachment}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'base_url' => $this->string(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string(),
            'order' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex('idx_blog_attachment', '{{%blog_attachment}}', 'order');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_blog_attachment', '{{%blog_attachment}}');
        $this->dropForeignKey('fk_blog_lang', '{{%blog_lang}}');
        $this->dropForeignKey('fk_blog_updated_by', '{{%blog}}');
        $this->dropForeignKey('fk_blog_created_by', '{{%blog}}');

        $this->dropTable('{{%blog_attachment}}');
        $this->dropTable('{{%blog_lang}}');
        $this->dropTable('{{%blog}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210715_164037_blog cannot be reverted.\n";

        return false;
    }
    */
}
