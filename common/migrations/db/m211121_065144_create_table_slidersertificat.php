<?php

use yii\db\Migration;

/**
 * Class m211121_065144_create_table_slidersertificat
 */
class m211121_065144_create_table_slidersertificat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("{{%slider_sertificat}}", [
            'id' => $this->primaryKey(),
            'image_path' => $this->string(512)->notNull(),
            'image_base_url' => $this->string(512)->notNull(),
            'button_url' => $this->string(512),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%slider_sert_lang}}', [
            'id' => $this->primaryKey(),
            'slider_id' => $this->integer()->notNull(),
            'language' => $this->string(64)->notNull(),
            'title' => $this->string(512),
            'text' => $this->text(),
            'button_text' => $this->string(255),
        ]);

        $this->addForeignKey('fk_slider_sert_lang', '{{%slider_sert_lang}}', 'slider_id', '{{%slider_sertificat}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_slider_sert_lang', '{{%slider_sert_lang}}');
        $this->dropTable('{{%slider_sert_lang}}');
        $this->dropTable('{{%slider_sertificat}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211121_065144_create_table_slidersertificat cannot be reverted.\n";

        return false;
    }
    */
}
