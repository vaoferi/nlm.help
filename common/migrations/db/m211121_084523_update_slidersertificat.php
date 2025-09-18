<?php

use yii\db\Migration;

/**
 * Class m211121_084523_update_slidersertificat
 */
class m211121_084523_update_slidersertificat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%slider_sertificat}}', 'status', $this->smallInteger()->notNull()->defaultValue(0));
        $this->addColumn('{{%slider_sertificat}}', 'order', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%slider_sertificat}}', 'status');
        $this->dropColumn('{{%slider_sertificat}}', 'order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211121_084523_update_slidersertificat cannot be reverted.\n";

        return false;
    }
    */
}
