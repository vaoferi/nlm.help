<?php

use yii\db\Migration;

/**
 * Class m190328_151615_comparison_images_to_article
 */
class m190328_151615_comparison_images_to_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article}}', 'image_before_base_url', $this->string(1024));
        $this->addColumn('{{%article}}', 'image_before_path', $this->string(1024));
        $this->addColumn('{{%article}}', 'image_after_base_url', $this->string(1024));
        $this->addColumn('{{%article}}', 'image_after_path', $this->string(1024));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%article}}', 'image_before_base_url');
        $this->dropColumn('{{%article}}', 'image_before_path');
        $this->dropColumn('{{%article}}', 'image_after_base_url');
        $this->dropColumn('{{%article}}', 'image_after_path');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_151615_comparison_images_to_article cannot be reverted.\n";

        return false;
    }
    */
}
