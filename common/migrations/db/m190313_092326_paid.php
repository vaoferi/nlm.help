<?php

use yii\db\Migration;

/**
 * Class m190313_092326_paid
 */
class m190313_092326_paid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_project}}','amount_received', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_project}}','amount_received');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190313_092326_paid cannot be reverted.\n";

        return false;
    }
    */
}
