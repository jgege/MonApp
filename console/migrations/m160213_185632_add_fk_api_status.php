<?php

use yii\db\Migration;

class m160213_185632_add_fk_api_status extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_api_id', 'api_status', 'api_id', 'api', 'id');
    }

    public function down()
    {
        $this->dropColumn('api_status', 'api_id');
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
