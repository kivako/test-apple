<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m200129_021531_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apples}}', [
            'id' => $this->primaryKey(),
            'date_create' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'color' => $this->string(15),
            'body_percent' => $this->tinyInteger()->defaultValue(100),
            'status' => $this->string(10),
            'date_fall' => $this->timestamp()->defaultValue('0000-00-00 00:00:00'),
            'date_up' => $this->timestamp()->defaultValue('0000-00-00 00:00:00')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apples}}');
    }
}
