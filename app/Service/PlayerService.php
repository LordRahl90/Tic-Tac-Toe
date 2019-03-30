<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:58
 */

namespace App\Service;


use App\Repository\Eloquents\PlayerRepository;
use App\Service\Exceptions\BadIndexException;

class PlayerService
{

    protected $playerRepository;
    protected $boardService;

    public function __construct(
        PlayerRepository $playerRepository,
        BoardService $boardService
    )
    {
        $this->playerRepository=$playerRepository;
        $this->boardService=$boardService;
    }

    /**
     * @param $gameId
     * @param $userId
     * @param $character
     * @return mixed
     * @throws \Exception
     */
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

    /**
     * @param $playerId
     * @param $x
     * @param $y
     * @param MoveService $moveService
     */
    public function makeMove($playerId,$x,$y,MoveService $moveService){
        $player=$this->playerRepository->find($playerId);
        $character=$playerId->character;

        try{
            $moveService->move($player->game_id,$player->id,$x,$y,$character);
        }
        catch(\Exception $ex){
            throw new Exception($ex->getMessage());
        }
    }
}