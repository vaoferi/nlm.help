<?php

use yii\db\Migration;

/**
 * Class m190321_092157_slider
 */
class m190321_092157_slider extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("{{%slider}}", [
            'id' => $this->primaryKey(),
            'image_path' => $this->string(512)->notNull(),
            'image_base_url' => $this->string(512)->notNull(),
            'button_url' => $this->string(512),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%slider_lang}}', [
            'id' => $this->primaryKey(),
            'slider_id' => $this->integer()->notNull(),
            'language' => $this->string(64)->notNull(),
            'title' => $this->string(512),
            'text' => $this->text(),
            'button_text' => $this->string(255),
        ]);

        $this->addForeignKey('fk_slider_lang', '{{%slider_lang}}', 'slider_id', '{{%slider}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_slider_lang', '{{%slider_lang}}');
        $this->dropTable('{{%slider}}');
        $this->dropTable('{{%slider_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190321_092157_slider cannot be reverted.\n";

        return false;
    }
    */
}
