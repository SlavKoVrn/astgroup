<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    public $events = [];

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
            ['email', 'required'],
            ['email', 'email'],
            ['events', 'each', 'rule' => ['integer']],
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
            'events' => 'Мероприятия',
        ];
    }

    public function getSelectedEvents()
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])
            ->viaTable('{{%event2organizer}}', ['organizer_id' => 'id']);
    }

    public function getName()
    {
        return $this->id.'. '.$this->fio.' '.$this->email.' '.$this->phone;
    }

    public static function getAllArray()
    {
        return ArrayHelper::map(self::find()->all(),'id','name');
    }

    public function getSelectedEventsIds()
    {
        return ArrayHelper::map($this->selectedEvents,'id','id');
    }

    public function getSelectedEventsName()
    {
        return ArrayHelper::map($this->selectedEvents,'id','eventName');
    }

    public function eventsSave($newEventsIds)
    {
        $currentEventsIds = $this->getSelectedEventsIds();
        $toInsert = [];
        foreach (array_filter(array_diff($newEventsIds,$currentEventsIds)) as $eventId){
            $toInsert[] = $eventId;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($toInsert){
                foreach ($toInsert as $eventId){
                    $eventOrganizer = new Event2organizer;
                    $eventOrganizer->setAttributes([
                        'organizer_id' => $this->id,
                        'event_id' => $eventId,
                    ]);
                    $eventOrganizer->save();
                }
            }
            if ($toRemove = array_filter(array_diff($currentEventsIds,$newEventsIds))){
                Event2organizer::deleteAll([
                    'organizer_id'=>$this->id,
                    'event_id'=>$toRemove,
                ]);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

}
