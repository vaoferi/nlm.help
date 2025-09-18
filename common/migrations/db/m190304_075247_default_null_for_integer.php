<?php

use yii\db\Migration;

/**
 * Class m190304_075247_default_null_for_integer
 */
class m190304_075247_default_null_for_integer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%project}}', ['required_amount' => 0], ['required_amount' => null]);
        $this->update('{{%project}}', ['collected_amount' => 0], ['collected_amount' => null]);
        $this->alterColumn('{{%project}}', 'required_amount', $this->integer()->notNull()->defaultValue(0));
        $this->alterColumn('{{%project}}', 'collected_amount', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%project}}', 'required_amount', $this->integer());
        $this->alterColumn('{{%project}}', 'collected_amount', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190304_075247_default_null_for_integer cannot be reverted.\n";

        return false;
    }
    */
}
