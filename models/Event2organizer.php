<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%event2organizer}}".
 *
 * @property int $id
 * @property int|null $event_id
 * @property int|null $organizer_id
 */
class Event2organizer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event2organizer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'organizer_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'event_id' => 'Событие',
            'organizer_id' => 'Организатор',
        ];
    }

}
