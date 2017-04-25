<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bus`.
 */
class m170423_042838_create_bus_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('bus', [
            'id' => $this->primaryKey(),
            'mark' => $this->string(255)->notNull(),
            'model' => $this->string(255),
            'year' => $this->integer(11),
            'average_speed' => $this->integer(11)
        ]);

        $this->addForeignKey(
            'fk_bus_id',
            'driver',
            'bus_id',
            'bus',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('bus');
    }
}
