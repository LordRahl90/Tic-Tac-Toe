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
use Illuminate\Support\Facades\Log;

class PlayerService
{

    protected $playerRepository;
    protected $boardService;
    protected $moveService;

    public function __construct(
        PlayerRepository $playerRepository,
        BoardService $boardService,
        MoveService $moveService
    )
    {
        $this->playerRepository=$playerRepository;
        $this->boardService=$boardService;
        $this->moveService=$moveService;
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
     * @throws \Exception
     */
    public function makeMove($playerId,$x,$y){
        $player=$this->playerRepository->find($playerId);
        $character=$player->character;

        try{
            $this->moveService->move($player->game_id,$player->id,$x,$y,$character);
        }
        catch(\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
    }


    /**
     * @param $gameID
     * @return mixed
     */
    public function getBotPlayer($gameID){
        return $this->playerRepository->findBy('game_id',$gameID)->where('user_id',1)->first();
    }
}