<?php

use yii\db\Migration;

/**
 * Class m190228_135744_contacts
 */
class m190228_135744_contacts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%help_center}}', [
            'id' => $this->primaryKey(),
            'place_name' => $this->string(255),
        ]);

        $this->createTable('{{%help_center_service}}', [
            'id' => $this->primaryKey(),
            'help_center_id' => $this->integer(),
            'service_name' => $this->string(255),
        ]);

        $this->addForeignKey('fk_help_center', '{{%help_center_service}}', 'help_center_id', '{{%help_center}}', 'id', 'cascade', 'cascade');

        $this->createIndex('index_help_center_service', '{{%help_center_service}}', ['help_center_id', 'service_name'], true);

        $this->createTable('{{%help_center_lang}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(64),
            'help_center_id' => $this->integer(),
            'name' => $this->string(255),
            'description' => $this->text(),
            'contacts' => $this->text(),
        ]);

        $this->addForeignKey('fk_help_center_lang', '{{%help_center_lang}}', 'help_center_id', '{{%help_center}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%help_center_article}}', [
            'id' => $this->primaryKey(),
            'help_center_id' => $this->integer(),
            'article_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_help_center_article', '{{%help_center_article}}', 'article_id', '{{%article}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_help_center_article_center', '{{%help_center_article}}', 'help_center_id', '{{%help_center}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%help_center_project}}', [
            'id' => $this->primaryKey(),
            'help_center_id' => $this->integer(),
            'project_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_help_center_project', '{{%help_center_project}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_help_center_project_center', '{{%help_center_project}}', 'help_center_id', '{{%help_center}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_help_center', '{{%help_center_service}}');
        $this->dropForeignKey('fk_help_center_lang', '{{%help_center_lang}}');
        $this->dropForeignKey('fk_help_center_article', '{{%help_center_article}}');
        $this->dropForeignKey('fk_help_center_article_center', '{{%help_center_article}}');
        $this->dropForeignKey('fk_help_center_project', '{{%help_center_project}}');
        $this->dropForeignKey('fk_help_center_project_center', '{{%help_center_project}}');
        $this->dropIndex('index_help_center_service', '{{%help_center_service}}');
        $this->dropTable('{{%help_center}}');
        $this->dropTable('{{%help_center_service}}');
        $this->dropTable('{{%help_center_lang}}');
        $this->dropTable('{{%help_center_article}}');
        $this->dropTable('{{%help_center_project}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190228_135744_contacts cannot be reverted.\n";

        return false;
    }
    */
}
