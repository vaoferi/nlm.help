<?php

use yii\db\Migration;

/**
 * Class m190318_104315_order_category
 */
class m190318_104315_order_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_category}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer()->defaultValue(0),
            'comment' => $this->text(),
            'full_name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'payment_system' => $this->string(255),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('0 => new, 1 => paid'),
            'category_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'transaction_id' => $this->string(255),
            'amount_received' => $this->double()
        ]);

        $this->addForeignKey('fk_order_category', '{{%order_category}}', 'category_id', '{{%article_category}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_order_category', '{{%order_category}}');
        $this->dropTable('{{%order_category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190318_104315_order_category cannot be reverted.\n";

        return false;
    }
    */
}
