<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:51
 */

namespace App\Service;


use App\Repository\Eloquents\UserRepository;
use App\Service\Exceptions\GameException;

class UserService
{

    protected $userRepository;
    protected $gameService,$playerService;


    public function __construct(
        UserRepository $userRepository,
        GameService $gameService,
        PlayerService $playerService
    )
    {
        $this->userRepository=$userRepository;
        $this->gameService=$gameService;
        $this->playerService=$playerService;
    }


    /**
     * @param $fullname
     * @param $email
     * @param $character
     * @param $computerCharacter
     * @return mixed
     * @throws GameException
     */
    public function startGame($fullname,$email,$character,$computerCharacter){
        $newUser=$this->userRepository->firstOrCreate([
            'email'=>$email,
            'name'=>$fullname
        ]);

        if(!$newUser){
            throw new GameException("Error occurred while creating user");
        }

        //Create a new game
        $newGame=$this->gameService->startGame($newUser->id);

        //create a new player.
        $humanPlayer = $this->playerService->assignPlayer($newGame->id,$newUser->id,$character);
        $computer=$this->getComputer();
        //Create computer player.
        $this->playerService->assignPlayer($newGame->id,$computer->id,$computerCharacter);

        return $humanPlayer;
    }


    /**
     * @return mixed
     */
    public function getComputer(){
        return $this->userRepository->find(1);
    }

}