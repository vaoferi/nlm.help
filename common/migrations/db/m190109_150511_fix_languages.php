<?php

use yii\db\Migration;

/**
 * Class m190109_150511_fix_languages
 */
class m190109_150511_fix_languages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%user_profile}}', ['locale' => 'en'], 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190109_150511_fix_languages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190109_150511_fix_languages cannot be reverted.\n";

        return false;
    }
    */
}
