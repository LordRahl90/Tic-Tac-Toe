<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:54
 */

namespace App\Service;


use App\Repository\Eloquents\GameRepository;

class GameService
{
    protected $gameRepository;
    protected $boardService;

    public function __construct(GameRepository $gameRepository,BoardService $boardService)
    {
        $this->gameRepository=$gameRepository;
    }


    /**
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public function startGame($userId){
        $gameName=uniqid('game-');
        $newGame=$this->gameRepository->create([
            'user_id'=>$userId,
            'title'=>$gameName
        ]);

        if(!$newGame){
            throw new \Exception("An error occurred while creating the game");
        }

        return $newGame;
    }


}