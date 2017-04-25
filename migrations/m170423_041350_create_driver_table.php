<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `driver`.
 */
class m170423_041350_create_driver_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('driver', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull()->unique(),
            'photo' => $this->string(255),
            'birthday' => $this->date()->notNull(),
            'active' => $this->boolean()->notNull(),
            'bus_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('driver');
    }
}
