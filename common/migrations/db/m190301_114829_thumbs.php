<?php

use yii\db\Migration;

/**
 * Class m190301_114829_thumbs
 */
class m190301_114829_thumbs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%help_center}}', 'thumbnail_path', $this->string(512));
        $this->addColumn('{{%help_center}}', 'thumbnail_base_url', $this->string(512));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%help_center}}', 'thumbnail_path');
        $this->dropColumn('{{%help_center}}', 'thumbnail_base_url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190301_114829_thumbs cannot be reverted.\n";

        return false;
    }
    */
}
