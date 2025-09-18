<?php

use yii\db\Migration;

/**
 * Class m190228_114121_short_descriptions
 */
class m190228_114121_short_descriptions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%project_lang}}', 'short_description', $this->string(512));
        $this->addColumn('{{%article_lang}}', 'short_description', $this->string(512));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%project_lang}}', 'short_description');
        $this->dropColumn('{{%article_lang}}', 'short_description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190228_114121_short_descriptions cannot be reverted.\n";

        return false;
    }
    */
}
