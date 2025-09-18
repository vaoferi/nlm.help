<?php

use yii\db\Migration;

/**
 * Class m190315_141647_image_to_category
 */
class m190315_141647_image_to_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article_category}}', 'thumbnail_path', $this->string(512));
        $this->addColumn('{{%article_category}}', 'thumbnail_base_url', $this->string(512));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_category}}', 'thumbnail_path');
        $this->dropTable('{{%article_category}}', 'thumbnail_base_url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_141647_image_to_category cannot be reverted.\n";

        return false;
    }
    */
}
