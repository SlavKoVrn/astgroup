<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%events}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $date
 * @property string|null $description
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'date' => 'Дата проведения',
            'description' => 'Описание мероприятия',
        ];
    }

    public function getOrganizers()
    {
        return $this->hasMany(Organizer::class, ['id' => 'organizer_id'])
            ->viaTable('{{%event2organizer}}', ['event_id' => 'id']);
    }

}
