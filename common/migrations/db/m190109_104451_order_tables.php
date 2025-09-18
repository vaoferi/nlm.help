<?php

use yii\db\Migration;

/**
 * Class m190109_104451_order_tables
 */
class m190109_104451_order_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%partner}}', 'priority');
        $this->dropColumn('{{%project}}', 'priority');

        $this->createTable('{{%partner_order}}', [
            'id' => 'pk',
            'partner_id' => $this->integer(),
            'order' => $this->integer()
        ]);

        $this->addForeignKey('fk_partner_order', '{{%partner_order}}', 'partner_id', '{{%partner}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%project_order}}', [
            'id' => 'pk',
            'project_id' => $this->integer(),
            'order' => $this->integer()
        ]);

        $this->addForeignKey('fk_project_order', '{{%project_order}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%partner}}', 'priority', $this->integer());
        $this->addColumn('{{%project}}', 'priority', $this->integer());
        $this->dropForeignKey('fk_project_order', '{{%project_order}}');
        $this->dropForeignKey('fk_partner_order', '{{%partner_order}}');
        $this->dropTable('{{%partner_order}}');
        $this->dropTable('{{%project_order}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190109_104451_order_tables cannot be reverted.\n";

        return false;
    }
    */
}
