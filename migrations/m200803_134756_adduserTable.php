<?php

use yii\db\Migration;

/**
 * Class m200803_134756_adduserTable
 */
class m200803_134756_adduserTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', array(
            'id' => 'pk',
            'login' => 'string NOT NULL',
            'password' => 'string',
            'token' => 'string',
            'role' => 'string',
            'status' => 'string'
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200803_134756_adduserTable cannot be reverted.\n";
        $this->dropTable('users');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200803_134756_adduserTable cannot be reverted.\n";

        return false;
    }
    */
}
