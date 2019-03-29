<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:54
 */

namespace App\Repository\Eloquents;


use App\Models\Game;
use App\Repository\Repository;

class GameRepository extends Repository
{
    function model()
    {
        return Game::class;
    }


}