<?php

use yii\db\Migration;

/**
 * Class m190109_144553_multilanguage_partner
 */
class m190109_144553_multilanguage_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%partner}}', 'name');
        $this->dropColumn('{{%partner}}', 'description');
        $this->createTable('{{%partner_lang}}', [
            'id' => $this->primaryKey(),
            'partner_id' => $this->integer(),
            'language' => $this->string(6),
            'name' => $this->string(512),
            'description' => $this->text()
        ]);

        $this->addForeignKey('fk_partner_lang', '{{%partner_lang}}', 'partner_id', '{{%partner}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%partner}}', 'name', $this->string(512));
        $this->addColumn('{{%partner}}', 'description', $this->text());
        $this->dropForeignKey('fk_partner_lang', '{{%partner_lang}}');
        $this->dropTable('{{%partner_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190109_144553_multilanguage_partner cannot be reverted.\n";

        return false;
    }
    */
}
