<?php

use yii\db\Migration;

/**
 * Class m190510_121146_article_cron
 */
class m190510_121146_article_cron extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cron_log_detail}}', [
                'id' => $this->primaryKey(),
                'command_name' => $this->string(255)->notNull(),
                'time_start' => $this->integer()->notNull(),
                'time_end' => $this->integer(),
                'status' => $this->tinyInteger()->defaultValue(0),
                'description' => $this->text(),
            ]);

        $this->createTable('{{%cron_log_detail_error}}', [
                'id' => $this->primaryKey(),
                'cron_log_detail_id' => $this->integer()->notNull(),
                'description' => $this->text(),
                'status' => $this->tinyInteger()->defaultValue(0),
                'created_at' => $this->integer(),
            ]);

        $this->addForeignKey('cron_log_detail_error_cron_log_detail', '{{%cron_log_detail_error}}', 'cron_log_detail_id', '{{%cron_log_detail}}', 'id');

        $this->createTable('{{%article_cron}}', [
            'id' => $this->primaryKey(),
            'client' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'date' => $this->date()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_cron}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190510_121146_article_cron cannot be reverted.\n";

        return false;
    }
    */
}
