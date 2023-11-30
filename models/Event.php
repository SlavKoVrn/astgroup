<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    public $organizers = [];

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
            [['date'], 'safe'],
            [['date'], 'filter', 'filter' => function ($value) {
                return date('Y-m-d',strtotime($value));
            }],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            ['name', 'required'],
            ['organizers', 'each', 'rule' => ['integer']],
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
            'organizers' => 'Организаторы',
        ];
    }

    public function getSelectedOrganizers()
    {
        return $this->hasMany(Organizer::class, ['id' => 'organizer_id'])
            ->viaTable('{{%event2organizer}}', ['event_id' => 'id']);
    }

    public function getSelectedOrganizersIds()
    {
        return ArrayHelper::map($this->selectedOrganizers,'id','id');
    }

    public function getSelectedOrganizersName()
    {
        return ArrayHelper::map($this->selectedOrganizers,'id','name');
    }

    public function organizersSave($newOrganizersIds)
    {
        $currentOrganizersIds = $this->getSelectedOrganizersIds();
        $toInsert = [];
        foreach (array_filter(array_diff($newOrganizersIds,$currentOrganizersIds)) as $organizerId){
            $toInsert[] = $organizerId;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($toInsert){
                foreach ($toInsert as $organizerId){
                    $eventOrganizer = new Event2organizer;
                    $eventOrganizer->setAttributes([
                        'event_id' => $this->id,
                        'organizer_id' => $organizerId,
                    ]);
                    $eventOrganizer->save();
                }
            }
            if ($toRemove = array_filter(array_diff($currentOrganizersIds,$newOrganizersIds))){
                Event2organizer::deleteAll([
                    'event_id'=>$this->id,
                    'organizer_id'=>$toRemove
                ]);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    public function getEventName()
    {
        return $this->id.'. '.date('d.m.Y',strtotime($this->date)).' '.$this->name;
    }

    public static function getAllArray()
    {
        return ArrayHelper::map(self::find()->all(),'id','eventName');
    }

}
