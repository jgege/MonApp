<?php

use yii\db\Migration;

class m160213_173955_create_api extends Migration
{
    public function up()
    {
        $this->createTable('api', [
            'id' => $this->primaryKey(),
            'name' =>$this->string(),
            'endpoint' =>$this->string(),
            'access' =>$this->string(),
            'params' =>$this->string(),
            'requirement' =>$this->string(),
            'category' =>$this->string(),
            'updated_at' =>$this->bigInteger(),
            'created_at'=>$this->bigInteger()
        ]);
    }

    public function down()
    {
        $this->dropTable('api');
    }
}
