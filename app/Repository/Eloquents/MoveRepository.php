<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-30
 * Time: 11:30
 */

namespace App\Repository\Eloquents;


use App\Models\Move;
use App\Repository\Repository;

class MoveRepository extends Repository
{
    public function model()
    {
        return Move::class;
    }

    public function whereRaw($query,$data=[]){
        return $this->model->whereRaw($query,$data)->get();
    }





}