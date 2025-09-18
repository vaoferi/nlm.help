<?php

use yii\db\Migration;

/**
 * Class m190104_141140_partners
 */
class m190104_141140_partners extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partner}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512),
            'description' => $this->text(),
            'url' => $this->string(512),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('0 => not active, 1 => active'),
            'priority' => $this->integer(),
            'due_date' => $this->date(),
            'show_status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('0 => not show, 1 => show'),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%partner}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190104_141140_partners cannot be reverted.\n";

        return false;
    }
    */
}
