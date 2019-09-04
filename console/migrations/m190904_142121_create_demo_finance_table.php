<?php

use yii\db\Migration;

/**
 * Handles the creation of table `demo_finance`.
 */
class m190904_142121_create_demo_finance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%demo_finance}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->comment('Email'),
            'name' => $this->string()->comment('ФИО'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%demo_finance}}');
    }
}
