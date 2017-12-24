<?php

use yii\db\Migration;
use ut8ia\ecoclient\models\Units;
use ut8ia\ecoclient\models\Parameters;
use ut8ia\ecoclient\models\Reports;

class m171223_205721_init_functionality extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Units::tableName(), [
            'id' => $this->integer(11)->notNull(),
            'city_id' => $this->integer(11)->notNull(),
            'lattitude' => $this->string(32)->defaultValue(null),
            'longitude' => $this->string(32)->defaultValue(null),
            'status' => "enum('active', 'passive')",
            'comment' => $this->string(32)->null()
        ], $tableOptions);

        $this->createIndex('units_id_uniq', Units::tableName(), 'id', true);


        $this->createTable(Reports::tableName(), [
            'id' => $this->integer(11)->notNull(),
            'unit_id' => $this->integer(11)->notNull(),
            'formed' => "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'received' => "TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP",
        ], $tableOptions);

        $this->createIndex('reports_id_uniq', Reports::tableName(), 'id', true);


        $this->createTable(Parameters::tableName(), [
            'id' => $this->integer(11)->notNull(),
            'type' => "enum('temperature','humidity','dust10','dust25','gas')",
            'value' => $this->integer(11)->notNull(),
            'report_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('parameters_pk', Parameters::tableName(), 'id');
        $this->alterColumn(Parameters::tableName(), 'id', $this->integer(11) . ' NOT NULL AUTO_INCREMENT');

    }

    public function down()
    {
        $this->dropTable(Units::tableName());
        $this->dropTable(Reports::tableName());
        $this->dropTable(Parameters::tableName());
    }


}
