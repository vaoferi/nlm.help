<?php

use yii\db\Migration;

/**
 * Class m190116_123603_relations
 */
class m190116_123603_relations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article_partner}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'partner_id' => $this->integer()
        ]);

        $this->addForeignKey('fk_article_partner', '{{%article_partner}}', 'partner_id', '{{%partner}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_partner_article', '{{%article_partner}}', 'article_id', '{{%article}}', 'id', 'cascade', 'cascade');
        $this->createIndex('index_article_partner', '{{%article_partner}}', ['article_id', 'partner_id'], true);

        $this->createTable('{{%partner_project}}', [
            'id' => $this->primaryKey(),
            'partner_id' => $this->integer(),
            'project_id' => $this->integer()
        ]);

        $this->addForeignKey('fk_partner_project', '{{%partner_project}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_project_partner', '{{%partner_project}}', 'partner_id', '{{%partner}}', 'id', 'cascade', 'cascade');
        $this->createIndex('index_partner_project', '{{%partner_project}}', ['partner_id', 'project_id'], true);

        $this->createTable('{{%project_article}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'article_id' => $this->integer()
        ]);

        $this->addForeignKey('fk_project_article', '{{%project_article}}', 'article_id', '{{%article}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_project', '{{%project_article}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
        $this->createIndex('index_project_article', '{{%project_article}}', ['project_id', 'article_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_partner', '{{%article_partner}}');
        $this->dropForeignKey('fk_partner_article', '{{%article_partner}}');
        $this->dropForeignKey('fk_partner_project', '{{%partner_project}}');
        $this->dropForeignKey('fk_project_partner', '{{%partner_project}}');
        $this->dropForeignKey('fk_project_article', '{{%project_article}}');
        $this->dropForeignKey('fk_article_project', '{{%project_article}}');

        $this->dropIndex('index_article_partner', '{{%article_partner}}');
        $this->dropIndex('index_partner_project', '{{%partner_project}}');
        $this->dropIndex('index_project_article', '{{%project_article}}');

        $this->dropTable('{{%article_partner}}');
        $this->dropTable('{{%partner_project}}');
        $this->dropTable('{{%project_article}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190116_123603_relations cannot be reverted.\n";

        return false;
    }
    */
}
