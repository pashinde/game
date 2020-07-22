<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Game extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asses game whether team A Win or Lose';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private static function validateInput(String $str) : bool {
        
        if(preg_match("/[0-9]+,[0-9]+,[0-9]+,[0-9]+,[0-9]+/", $str)):
            return true;
        endif;

        return false;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $team_a_str = e($this->ask('Enter A Team Players:'));
        $team_b_str = e($this->ask('Enter B Team Players:'));
        
        if(! self::validateInput($team_a_str) || ! self::validateInput($team_b_str)):
            $this->error('Invalid Input: Enter only 5 integers for each team');
            return;
        endif;

        $team_a_arr = explode(',', $team_a_str);
        $team_b_arr = explode(',', $team_b_str);

        if(count($team_a_arr) != 5 && count($team_b_arr) != 5):
            $this->error('Both teams must have 5 players.');
            return;
        elseif(count($team_a_arr) != 5):
            $this->error('Team A must have 5 players.');
            return;
        elseif(count($team_b_arr) != 5):
            $this->error('Team B must have 5 players.');
            return;
        endif;

        if(! count(array_diff($team_a_arr, $team_b_arr))){
            $this->info('Tie');
            return;
        }

        foreach($team_a_arr as $key => $player_a_drain):

            if($player_a_drain < $team_b_arr[$key]){
                
                $this->info('Lose');
                return;
            }

        endforeach;

        $this->info('Win');
    }
}
