<?php

use yii\db\Migration;

class m160213_184109_api_status extends Migration
{
    public function up()
    {
        
        $this->createTable('api_status', [
            'api_id' => $this->integer()->notNull()->unique(),
            'name' =>$this->string(),
            'valid_json' =>$this->boolean(),
            'valid_data' =>$this->boolean(),
            'http_status' =>$this->string(),
            'request_sent_at' =>$this->bigInteger(),
            'latency' =>$this->integer()
        ]);
    }

    public function down()
    {
        $this->dropTable('api_status');
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
