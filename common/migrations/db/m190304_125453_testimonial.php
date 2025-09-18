<?php

use yii\db\Migration;

/**
 * Class m190304_125453_testimonial
 */
class m190304_125453_testimonial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("{{%testimonial}}", [
            'id' => $this->primaryKey(),
            'thumbnail_path' => $this->string(512),
            'thumbnail_base_url' => $this->string(512),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%testimonial_lang}}', [
            'id' => $this->primaryKey(),
            'testimonial_id' => $this->integer(),
            'language' => $this->string(64),
            'title' => $this->string(512),
            'text' => $this->text(),
        ]);

        $this->addForeignKey('fk_testimonial_lang', '{{%testimonial_lang}}', 'testimonial_id', '{{%testimonial}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_testimonial_lang', '{{%testimonial_lang}}');
        $this->dropTable('{{%testimonial}}');
        $this->dropTable('{{%testimonial_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190304_125453_testimonial cannot be reverted.\n";

        return false;
    }
    */
}
