<?php

use yii\db\Migration;

/**
 * Class m181228_121441_projects
 */
class m181228_121441_projects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('0 => draft, 1 => active'),
            'is_finished' => $this->boolean()->notNull()->defaultValue(false),
            'required_amount' => $this->integer(),
            'collected_amount' => $this->integer(),
            'priority' => $this->integer(),
            'due_date' => $this->date(),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'published_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable('{{%project_attachment}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'base_url' => $this->string(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string(),
            'created_at' => $this->integer()
        ]);

        $this->addForeignKey('fk_article_attachment_project', '{{%project_attachment}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_attachment_project', '{{%project_attachment}}');
        $this->dropTable('{{%project_attachment}}');
        $this->dropTable('{{%project}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181228_121441_projects cannot be reverted.\n";

        return false;
    }
    */
}
