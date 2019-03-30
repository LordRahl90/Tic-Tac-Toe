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


    /**
     * @param $board
     * @return bool
     */
    public function isBoardFilled($board){
        foreach ($board as $i=>$x){
            foreach($board[$i] as $j=>$y){
                if($board[$i][$j]==="" || $board[$i][$j]==null ){
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * @param $board
     * @return array
     */
    public function verifyWinning($board){
        $diagonal=[];
        $reverseDiagonal=[];
        $cols=[];
        $rows=[];

        foreach ($board as $i=>$x){

            foreach ($board[$i] as $j=>$y){
                $item=$board[$i][$j];
                $cols[$j][]=$item;
                $rows[$i][]=$item;

                if($i==$j){
                    $diagonal[]=$item;
                }
                if($i+$j===count($board[$i])){
                    $reverseDiagonal[]=$item;
                }
            }
        }

        if(count(array_unique($diagonal))===1){
            if($diagonal[0]!=="" && $diagonal[0]!==null){
                return [
                    'found'=>true,
                    'winner'=>$diagonal[0]
                ];
            }
        }

        if(count(array_unique($reverseDiagonal))===1){
            if($reverseDiagonal[0]!=="" && $reverseDiagonal[0]!==null){
                return[
                    'found'=>true,
                    'winner'=>$reverseDiagonal[0]
                ];
            }
        }

        foreach ($rows as $r){
            if(count(array_unique($r))===1){
                if($r[0]!=="" && $r[0]!==null){
                    return [
                        'found'=>true,
                        'winner'=>$r[0]
                    ];
                }
            }
        }

        foreach ($cols as $c){
            if(count(array_unique($c))===1){
                if($c[0]!=="" && $c[0]!==null){
                    return [
                        'found'=>true,
                        'winner'=>$c[0]
                    ];
                }
            }
        }

        return [
            'found'=>false
        ];
    }

}