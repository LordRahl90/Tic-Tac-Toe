<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:58
 */

namespace App\Service;


use App\Repository\Eloquents\PlayerRepository;

class PlayerService
{

    protected $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository=$playerRepository;
    }

    public function assignPlayer($gameId,$userId,$character){
        $newPlayer= $this->playerRepository->create([
            'user_id'=>$userId,
            'game_id'=>$gameId,
            'character'=>$character
        ]);

        if(!$newPlayer){
            throw new \Exception("An error occurred while attaching the player to the game");
        }

        return $newPlayer;
    }
}