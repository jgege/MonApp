<?php

use yii\db\Migration;

class m160213_215859_alter__api_status extends Migration
{
    public function up()
    {
        $this->dropColumn('api_status', 'name');
        $this->addColumn('api_status', 'api_status_code', $this->string());
    }

    public function down()
    {
        $this->dropColumn('api_status', 'api_status_code');
    }
}
