<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.06.2020
 * Time: 0:41
 */

namespace App\Console\Commands;

use App\Model\Commute\Google\DistanceCommuter;
use App\Model\Commute\Google\TimeCommuter;
use App\Model\Commute\StraightCommuter;
use Illuminate\Console\Command;

use App\Model\Commute\AbstractCommuter;

use Symfony\Component\Console\Input\InputArgument;

class CalculateCommute extends Command
{
    const CALCULATION_STRAIGHT_DISTANCE = '1';
    const CALCULATION_GOOGLE_DISTANCE = '2';
    const CALCULATION_GOOGLE_TIME = '3';

    protected $signature = 'calculateCommute {homeCoords} {workCoords} {timeCalculation=1} {scoreTransformation=1}';

    protected $name = 'calculateCommute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the typical duration of travel, then transform the result into 
        a numeric score and return the score value.';


    protected function getArguments()
    {
        return [
            ['homeCoords', null, InputArgument::REQUIRED,
                'Home coordinates.', null],
            ['workCoords', null, InputArgument::REQUIRED,
                'Work coordinates.', null],
            ['timeCalculation', null, InputArgument::OPTIONAL,
                'Specified algorithm for calculating the typical commuting duration.', null],
            ['scoreTransformation', null, InputArgument::OPTIONAL,
                'Transform the result in minutes into a numeric score.', null],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            $homeCoords = $this->argument('homeCoords');
            $workCoords = $this->argument('workCoords');

            $timeCalculation = $this->argument('timeCalculation');
            $scoreTransformation = $this->argument('scoreTransformation');

            /** @var AbstractCommuter */
            $commuter = null;

            switch ($timeCalculation) {
                case self::CALCULATION_STRAIGHT_DISTANCE:
                    $commuter = new StraightCommuter($homeCoords, $workCoords);
                    break;
                case self::CALCULATION_GOOGLE_DISTANCE:
                    $commuter = new DistanceCommuter($homeCoords, $workCoords);
                    break;
                case self::CALCULATION_GOOGLE_TIME:
                    $commuter = new TimeCommuter($homeCoords, $workCoords);
                    break;
                default:
                    throw new \Exception('Incorrect calculation method: ' . $timeCalculation);
            }

            $time = $commuter->getCommutingDuration();

            $this->info('Commuting duration: ' . $time . ' minutes.');

            $score = $commuter->getScore($scoreTransformation);

            $this->info('Commuting score: ' . $score . '.');

        }
        catch (\Exception $e)
        {
            $this->info($e->getMessage());
        }

        return 0;
    }
}