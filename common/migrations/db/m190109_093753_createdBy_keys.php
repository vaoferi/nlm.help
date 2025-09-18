<?php

use yii\db\Migration;

/**
 * Class m190109_093753_createdBy_keys
 */
class m190109_093753_createdBy_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_project_created_by', '{{%project}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_partner_created_by', '{{%partner}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_project_updated_by', '{{%project}}', 'updated_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_partner_updated_by', '{{%partner}}', 'updated_by', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_created_by', '{{%project}}');
        $this->dropForeignKey('fk_project_created_by', '{{%partner}}');
        $this->dropForeignKey('fk_project_updated_by', '{{%project}}');
        $this->dropForeignKey('fk_project_updated_by', '{{%partner}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190109_093753_createdBy_keys cannot be reverted.\n";

        return false;
    }
    */
}
