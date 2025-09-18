<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m190329_092348_user_display
 */
class m190329_092348_user_display extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'display', $this->smallInteger()->notNull()->defaultValue(User::DISPLAY_FALSE));
        $this->addColumn('{{%user}}', 'photo_base_url', $this->string(1024));
        $this->addColumn('{{%user}}', 'photo_path', $this->string(1024));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'display');
        $this->dropColumn('{{%user}}', 'photo_base_url');
        $this->dropColumn('{{%user}}', 'photo_path');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190329_092348_user_display cannot be reverted.\n";

        return false;
    }
    */
}
