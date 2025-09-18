<?php

use yii\db\Migration;

/**
 * Class m190318_122622_order_service
 */
class m190318_122622_order_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_service}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer()->defaultValue(0),
            'comment' => $this->text(),
            'full_name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'payment_system' => $this->string(255),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('0 => new, 1 => paid'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'transaction_id' => $this->string(255),
            'amount_received' => $this->double()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_service}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190318_122622_order_service cannot be reverted.\n";

        return false;
    }
    */
}
