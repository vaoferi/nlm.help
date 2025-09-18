<?php

use yii\db\Migration;

/**
 * Class m190329_094536_user_social_network_table
 */
class m190329_094536_user_social_network_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_social_network}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'social_network' => $this->smallInteger()->notNull(),
            'link' => $this->string(400),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_user_social_network', '{{%user_social_network}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->addColumn('{{%user_profile}}', 'info',  $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_profile}}', 'info');
        $this->dropForeignKey('fk_user_social_network', '{{%user_social_network}}');
        $this->dropTable('{{%user_social_network}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190329_094536_user_social_network_table cannot be reverted.\n";

        return false;
    }
    */
}
