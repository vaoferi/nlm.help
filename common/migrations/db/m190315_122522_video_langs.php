<?php

use yii\db\Migration;

/**
 * Class m190315_122522_video_langs
 */
class m190315_122522_video_langs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%video}}', 'embed_code');
        $this->addColumn('{{%video_lang}}', 'embed_code', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%video}}', 'embed_code', $this->text());
        $this->dropColumn('{{%video_lang}}', 'embed_code');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_122522_video_langs cannot be reverted.\n";

        return false;
    }
    */
}
