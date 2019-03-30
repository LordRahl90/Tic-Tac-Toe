<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;

    public $guarded=['deleted_at'];

    public function players(){
        return $this->hasMany(Player::class);
    }
}
