<?php

namespace Tests\Unit;

use Tests\TestCase;

class GameAssesTest extends TestCase
{

    public function test_app_has_game_asses_command()
    {
        $this->assertTrue(class_exists(\App\Console\Commands\Game::class));
    }

    public function test_game_asses_command_has_invalid_input(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', 'asde,20,35,50,100')
        ->expectsQuestion('Enter B Team Players:', '35,10,30,20,90')
        ->expectsOutput('Invalid Input: Enter only 5 integers for each team');
    }

    public function test_both_teams_must_have_five_players(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', '100,20,50,11,11,234')
        ->expectsQuestion('Enter B Team Players:', '90,12,12,22,333,4444')
        ->expectsOutput('Both teams must have 5 players.');
    }

    public function test_team_a_must_have_five_players(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', '30,100,20,50,11,456,234')
        ->expectsQuestion('Enter B Team Players:', '35,10,90,12,12')
        ->expectsOutput('Team A must have 5 players.');
    }

    public function test_team_b_must_have_five_players(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', '30,100,20,50,11')
        ->expectsQuestion('Enter B Team Players:', '90,12,12,123,123,123')
        ->expectsOutput('Team B must have 5 players.');
    }

    public function test_game_asses_command_with_team_a_wins(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', '40,20,35,50,100')
        ->expectsQuestion('Enter B Team Players:', '35,10,30,20,90')
        ->expectsOutput('Win');
    }

    public function test_game_asses_command_with_team_a_loses(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', '30,100,20,50,40')
        ->expectsQuestion('Enter B Team Players:', '35,10,30,20,90')
        ->expectsOutput('Lose');
    }

    public function test_game_asses_command_for_tie(){
        $this->artisan('game')
        ->expectsQuestion('Enter A Team Players:', '30,100,20,50,11')
        ->expectsQuestion('Enter B Team Players:', '30,100,20,50,11')
        ->expectsOutput('Tie');
    }

}
