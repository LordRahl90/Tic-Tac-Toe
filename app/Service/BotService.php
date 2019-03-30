<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-30
 * Time: 15:58
 */

namespace App\Service;


use App\Repository\Eloquents\PlayerRepository;
use Faker\Factory;
use Illuminate\Support\Facades\Log;

class BotService
{
    protected $playerRepository,$gameRepository,$playerService;


    public function __construct(
        PlayerRepository $playerRepository,
        PlayerService $playerService)
    {
        $this->playerRepository=$playerRepository;
        $this->playerService=$playerService;
    }


    /**
     * @param $gameID
     * @param $board
     * @return array
     * @throws \Exception
     */
    public function play($gameID,$board){
        $botPlayer=$this->playerService->getBotPlayer($gameID);

        $options=[];

        foreach($board as $i=>$x){
            foreach ($board[$i] as $j=>$y) {
                if($board[$i][$j]==""){
                    $options[]=$i.','.$j;
                }
            }
        }
        if(count($options)<=0){
            return [
                'board'=>$board,
                'x'=>null,
                'y'=>null
            ];
        }

        shuffle($options);
        $selected=$options[0];
        $xy=explode(",",$selected);
        $i=$xy[0];
        $j=$xy[1];

        $board[$i][$j]=$botPlayer->character;
        $this->playerService->makeMove($botPlayer->id,$i,$j);
        return [
            'board'=>$board,
            'x'=>$i,
            'y'=>$j
        ];
    }

}