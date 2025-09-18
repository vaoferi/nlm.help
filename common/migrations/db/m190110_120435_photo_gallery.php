<?php

use yii\db\Migration;

/**
 * Class m190110_120435_photo_gallery
 */
class m190110_120435_photo_gallery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photo_album}}', [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('0 => not active, 1 => active'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'slug' => $this->string(1024)->notNull(),
        ]);

        $this->createTable('{{%photo_album_lang}}', [
            'id' => $this->primaryKey(),
            'photo_album_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(512),
        ]);

        $this->addForeignKey('fk_photo_album_lang', '{{%photo_album_lang}}', 'photo_album_id', '{{%photo_album}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey(),
            'photo_base_url' => $this->string(1024),
            'photo_path' => $this->string(1024),
            'photo_album_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_photo_album', '{{%photo}}', 'photo_album_id', '{{%photo_album}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%photo_lang}}', [
            'id' => $this->primaryKey(),
            'photo_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(512),
            'description' => $this->text(),
            'alt' => $this->string(512)
        ]);

        $this->addForeignKey('fk_photo_lang', '{{%photo_lang}}', 'photo_id', '{{%photo}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_photo_lang', '{{%photo_lang}}');
        $this->dropForeignKey('fk_photo_album_lang', '{{%photo_album_lang}}');
        $this->dropForeignKey('fk_photo_album', '{{%photo}}');
        $this->dropTable('{{%photo_album}}');
        $this->dropTable('{{%photo_album_lang}}');
        $this->dropTable('{{%photo}}');
        $this->dropTable('{{%photo_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190110_120435_photo_gallery cannot be reverted.\n";

        return false;
    }
    */
}
