<?php

use yii\db\Migration;

/**
 * Class m231128_194343_basa
 */
class m231128_194343_basa extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%events}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'date' => $this->date(),
            'description' => $this->text(),
        ], $tableOptions);

        $this->batchInsert('{{%events}}', ['name','date','description'], [
            ['Событие 1','2023-01-01','Описание события 1'],
            ['Событие 2','2023-02-02','Описание события 2'],
            ['Событие 3','2023-03-03','Описание события 3'],
        ]);

        $this->createTable('{{%organizers}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
        ], $tableOptions);

        $this->batchInsert('{{%organizers}}', ['fio','email','phone'], [
            ['Организатор 1','organizer1@mail.ru','+78002001001'],
            ['Организатор 2','organizer2@mail.ru','+78002001002'],
            ['Организатор 3','organizer3@mail.ru','+78002001003'],
        ]);


        $this->createTable('{{%event2organizer}}', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'organizer_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            '{{%idx-event2organizer-event_id}}',
            '{{%event2organizer}}',
            'event_id'
        );

        $this->createIndex(
            '{{%idx-event2organizer-organizer_id}}',
            '{{%event2organizer}}',
            'organizer_id'
        );

        $this->batchInsert('{{%event2organizer}}', ['event_id','organizer_id'], [
            [1,1],
            [1,2],
            [1,3],
            [2,1],
            [2,2],
            [2,3],
            [3,1],
            [3,2],
            [3,3],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-event2organizer-event_id}}','{{%event2organizer}}');
        $this->dropIndex('{{%idx-event2organizer-organizer_id}}','{{%event2organizer}}');

        $this->dropTable('{{%event2organizer}}');
        $this->dropTable('{{%organizers}}');
        $this->dropTable('{{%events}}');
    }

}
