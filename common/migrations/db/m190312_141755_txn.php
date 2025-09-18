<?php

use yii\db\Migration;

/**
 * Class m190312_141755_txn
 */
class m190312_141755_txn extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_project}}', 'transaction_id', $this->string(255));
        $this->addColumn('{{%payment_log}}', 'transaction_id', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_project}}', 'transaction_id');
        $this->dropColumn('{{%payment_log}}', 'transaction_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190312_141755_txn cannot be reverted.\n";

        return false;
    }
    */
}
