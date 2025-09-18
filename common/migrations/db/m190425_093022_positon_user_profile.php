<?php

use yii\db\Migration;

/**
 * Class m190425_093022_positon_user_profile
 */
class m190425_093022_positon_user_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{user_profile}}', 'position', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_profile}}', 'position');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190425_093022_positon_user_profile cannot be reverted.\n";

        return false;
    }
    */
}
