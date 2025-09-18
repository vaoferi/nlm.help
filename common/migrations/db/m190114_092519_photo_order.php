<?php

use yii\db\Migration;

/**
 * Class m190114_092519_photo_order
 */
class m190114_092519_photo_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%photo}}', 'order', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%photo}}', 'order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190114_092519_photo_order cannot be reverted.\n";

        return false;
    }
    */
}
