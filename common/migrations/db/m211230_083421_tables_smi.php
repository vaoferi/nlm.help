<?php

use yii\db\Migration;

/**
 * Class m211230_083421_tables_smi
 */
class m211230_083421_tables_smi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("{{%catalog_smi}}", [
            'id' => $this->primaryKey(),
            'image_path' => $this->string(512)->notNull(),
            'image_base_url' => $this->string(512)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('{{%catalog_smi_lang}}', [
            'id' => $this->primaryKey(),
            'cat_smi_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'title' => $this->string(512),
        ]);

        $this->addForeignKey('fk_catalog_smi_lang', '{{%catalog_smi_lang}}', 'cat_smi_id', '{{%catalog_smi}}', 'id', 'cascade', 'cascade');


        $this->createTable("{{%smi}}", [
            'id' => $this->primaryKey(),
            'cat_smi_id' => $this->integer()->notNull(),
            'url' => $this->string(512),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('{{%smi_lang}}', [
            'id' => $this->primaryKey(),
            'smi_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'preview' => $this->text(),
        ]);

        $this->addForeignKey('fk_smi_lang', '{{%smi_lang}}', 'smi_id', '{{%smi}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_smi_catalog_smi', '{{%smi}}', 'cat_smi_id', '{{%catalog_smi}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_smi_catalog_smi', '{{%smi}}');
        $this->dropForeignKey('fk_smi_lang', '{{%smi_lang}}');
        $this->dropTable('{{%smi_lang}}');
        $this->dropTable('{{%smi}}');

        $this->dropForeignKey('fk_catalog_smi_lang', '{{%catalog_smi_lang}}');
        $this->dropTable('{{%catalog_smi_lang}}');
        $this->dropTable('{{%catalog_smi}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211230_083421_tables_smi cannot be reverted.\n";

        return false;
    }
    */
}
