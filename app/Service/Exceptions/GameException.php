<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 15:05
 */

namespace App\Service\Exceptions;


use Illuminate\Support\Facades\Log;
use Throwable;

class GameException extends \Exception
{

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        Log::info($message);
    }

}