<?php

use yii\db\Migration;

/**
 * Class m190221_151655_payment_log
 */
class m190221_151655_payment_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_log}}', [
            'id' => $this->primaryKey(),
            'payment_system' => $this->string(64),
            'body' => $this->text(),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_log}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190221_151655_payment_log cannot be reverted.\n";

        return false;
    }
    */
}
