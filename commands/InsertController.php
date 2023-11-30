<?php
namespace app\commands;

use app\models\Event;
use app\models\Organizer;
use app\models\Event2organizer;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Migration;
use Faker\Factory;

class InsertController extends Controller
{
    public function actionIndex()
    {
        //---------------------------------------
        $migration = new Migration;
        $migration->truncateTable('events');

        $start_date = strtotime('2020-01-01');
        $end_date = strtotime('2023-12-31');

        $faker = Factory::create('ru_RU');
        for ($i = 1; $i <= 100; $i++) {
            $random_timestamp = mt_rand($start_date, $end_date);
            $random_date = date('Y-m-d', $random_timestamp);
            $event = new Event;
            $event->setAttributes([
                'name' => $faker->realText(22),
                'description' => $faker->realText(1024),
                'date' => $random_date,
            ]);
            $event->save();
            echo "$event->id. $event->date - $event->name\n";
        }
        //---------------------------------------
        $migration->truncateTable('organizers');
        for ($i = 1; $i <= 100; $i++) {
            $organizer = new Organizer;
            $organizer->setAttributes([
                'fio' => $faker->userName(),
                'email' => $faker->email(),
                'phone' => $faker->phoneNumber(),
            ]);
            $organizer->save();
            echo "$organizer->id. $organizer->fio - $organizer->email - $organizer->phone\n";
        }
        //---------------------------------------
        $migration->truncateTable('event2organizer');
        $events = Event::find()->all();
        foreach ($events as $event) {
            $countOrganizers = rand(1,5);
            for ($i = 1; $i <= $countOrganizers; $i++) {
                $event2organizer = new Event2organizer;
                $event2organizer->setAttributes([
                    'event_id' => $event->id,
                    'organizer_id' => rand(1,100),
                ]);
                $event2organizer->save();
            }
            echo "$event2organizer->id\n";
        }
        //---------------------------------------
        return ExitCode::OK;
    }
}
