<?php

use yii\db\Migration;

/**
 * Class m190315_130325_about_us
 */
class m190315_130325_about_us extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article}}', 'about_us', $this->boolean());
        $this->addColumn('{{%article}}', 'about_us_path', $this->string(255));
        $this->addColumn('{{%article}}', 'about_us_base_url', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%article}}', 'about_us');
        $this->dropColumn('{{%article}}', 'about_us_path');
        $this->dropColumn('{{%article}}', 'about_us_base_url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_130325_about_us cannot be reverted.\n";

        return false;
    }
    */
}
