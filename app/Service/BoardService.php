<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 13:15
 */

namespace App\Service;


use App\Service\Exceptions\BadIndexException;
use App\Service\Exceptions\InvalidCharacterException;
use Illuminate\Support\Facades\Log;

class BoardService
{

    protected $board;


    /**
     * @return array
     */
    public function createBoard(){
        $x=3;
        $y=3;
        $board=[];


        for ($i=0; $i<$x; $i++){
            for($j=0; $j<$y; $j++){
                Log::info($i.' '.$j);
                $board[$i][$j]="";
            }
        }

        return $board;
    }

    /**
     * @param $board
     * @param $character
     * @param $x
     * @param $y
     * @return mixed
     * @throws BadIndexException
     * @throws InvalidCharacterException
     */
    public function addToBoard($board,$character,$x,$y){
        if($x<0 || $x>2){
            throw new BadIndexException("Column Index cannot be less than zero or greater than 2");
        }

        if($y>2){
            throw new BadIndexException("Row Index Cannot be less than zero or greater than 2");
        }
        if($character!=="O" && $character!=="X"){
            throw new InvalidCharacterException("Only 2 Characters Exist 'X' and 'O'".$character);
        }
        $board[$x][$y]=$character;
        return $board;
    }

}