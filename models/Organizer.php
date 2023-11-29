<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%organizers}}".
 *
 * @property int $id
 * @property string|null $fio
 * @property string|null $email
 * @property string|null $phone
 */
class Organizer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organizers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'email', 'phone'], 'string', 'max' => 255],
            ['fio', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'fio' => 'ФИО',
            'email' => 'Почта',
            'phone' => 'Телефон',
        ];
    }

    public function getEvents()
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])
            ->viaTable('{{%event2organizer}}', ['organizer_id' => 'id']);
    }

}
