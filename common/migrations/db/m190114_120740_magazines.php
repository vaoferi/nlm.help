<?php

use yii\db\Migration;

/**
 * Class m190114_120740_magazines
 */
class m190114_120740_magazines extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%magazine}}', [
            'id' => $this->primaryKey(),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'number' => $this->integer(),
            'attachment_path' => $this->string(1024),
            'attachment_base_url' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createTable('{{%magazine_lang}}', [
            'id' => $this->primaryKey(),
            'magazine_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(255),
            'alt' => $this->string(255)
        ]);

        $this->addForeignKey('fk_magazine_created_by', '{{%magazine}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_magazine_updated_by', '{{%magazine}}', 'updated_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_magazine_lang', '{{%magazine_lang}}', 'magazine_id', '{{%magazine}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_magazine_created_by', '{{%magazine}}');
        $this->dropForeignKey('fk_magazine_updated_by', '{{%magazine}}');
        $this->dropForeignKey('fk_magazine_lang', '{{%magazine_lang}}');
        $this->dropTable('{{%magazine}}');
        $this->dropTable('{{%magazine_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190114_120740_magazines cannot be reverted.\n";

        return false;
    }
    */
}
