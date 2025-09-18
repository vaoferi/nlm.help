<?php

use yii\db\Migration;

/**
 * Class m190114_133139_video
 */
class m190114_133139_video extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%video}}', [
            'id' => $this->primaryKey(),
            'embed_code' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createTable('{{%video_lang}}', [
            'id' => $this->primaryKey(),
            'video_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(255),
            'description' => $this->text(),
        ]);

        $this->addForeignKey('fk_video_lang', '{{%video_lang}}', 'video_id', '{{%video}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_video_created_by', '{{%video}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_video_updated_by', '{{%video}}', 'updated_by', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_video_lang', '{{%video_lang}}');
        $this->dropForeignKey('fk_video_created_by', '{{%video}}');
        $this->dropForeignKey('fk_video_updated_by', '{{%video}}');
        $this->dropTable('{{%video}}');
        $this->dropTable('{{%video_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190114_133139_video cannot be reverted.\n";

        return false;
    }
    */
}
