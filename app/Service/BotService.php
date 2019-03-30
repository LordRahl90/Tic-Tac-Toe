<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-30
 * Time: 15:58
 */

namespace App\Service;


use App\Repository\Eloquents\PlayerRepository;

class BotService
{
    protected $playerRepository,$gameRepository,$playerService;


    public function __construct(PlayerRepository $playerRepository,PlayerService $playerService)
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

        foreach($board as $i=>$x){
            foreach ($board[$i] as $j=>$y) {
                if($board[$i][$j]==""){
                    $board[$i][$j]=$botPlayer->character;
                    $this->playerService->makeMove($botPlayer->id,$i,$j);
                    return [
                        'board'=>$board,
                        'x'=>$i,
                        'y'=>$j
                    ];
                }
            }
        }
    }


}