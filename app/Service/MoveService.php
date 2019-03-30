<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-30
 * Time: 11:29
 */

namespace App\Service;


use App\Models\Move;
use App\Repository\Eloquents\MoveRepository;
use Illuminate\Support\Facades\Log;

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
        $checkResult=$this->moveRepository->whereRaw('game_id=? and x_index=? and y_index=?',[$gameID,$x,$y]);
        if(count($checkResult)>0){
            Log::info($checkResult);
            throw new \Exception("Invalid Move");
        }

        $newMove=$this->moveRepository->create([
            'game_id'=>$gameID,
            'player_id'=>$playerID,
            'x_index'=>$x,
            'y_index'=>$y,
            'character'=>$character,
            'status'=>false
        ]);

        if(!$newMove){
            throw new \Exception("An error occurred while updating the move.");
        }

        return true;
    }

}