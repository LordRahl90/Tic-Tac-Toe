<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-30
 * Time: 11:29
 */

namespace App\Service;


use App\Repository\Eloquents\MoveRepository;

class MoveService
{
    protected $moveRepository;
    private $boardService;

    public function __construct(MoveRepository $moveRepository,BoardService $boardService)
    {
        $this->moveRepository=$moveRepository;
        $this->boardService=$boardService;
    }


    /**
     * @param $gameID
     * @param $playerID
     * @param $x
     * @param $y
     * @param $character
     * @return bool
     * @throws \Exception
     */
    public function move($gameID,$playerID,$x,$y,$character){
        $checkResult=$this->moveRepository->model()->where('game_id',$gameID)->where('x_index',$x)->where('y_index',$y)->get();
        if(count($checkResult)>0){
            throw new \Exception("Invalid Move");
        }

        $newMove=$this->moveRepository->create([
            'game_id'=>$gameID,
            'player_id'=>$playerID,
            'x_index'=>$x,
            'y_index'=>$y,
            'character'=>$character
        ]);

        if(!$newMove){
            throw new \Exception("An error occurred while updating the move.");
        }

        return true;
    }

}