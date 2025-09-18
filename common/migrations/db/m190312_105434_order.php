<?php

use yii\db\Migration;

/**
 * Class m190312_105434_order
 */
class m190312_105434_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_project}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer()->defaultValue(0),
            'comment' => $this->text(),
            'full_name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'payment_system' => $this->string(255),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('0 => new, 1 => paid'),
            'project_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('fk_order_project', '{{%order_project}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_order_project', '{{%order_project}}');
        $this->dropTable('{{%order_project}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190312_105434_order cannot be reverted.\n";

        return false;
    }
    */
}
