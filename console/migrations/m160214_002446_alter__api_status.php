<?php

use yii\db\Migration;

class m160214_002446_alter__api_status extends Migration
{
    public function up()
    {
        $this->addColumn('api_status', 'last_time_worked_at', $this->bigInteger());
    }

    public function down()
    {
        $this->dropColumn('api_status', 'last_time_worked_at');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
