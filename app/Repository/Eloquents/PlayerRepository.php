<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:57
 */

namespace App\Repository\Eloquents;


use App\Models\Player;
use App\Repository\Repository;

class PlayerRepository extends Repository
{
    function model()
    {
        return Player::class;
    }


}