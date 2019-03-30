<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repository\Eloquents\UserRepository;
use App\Service\BoardService;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GameAPIController extends AppBaseController
{

    public function start(Request $request,
                          BoardService $boardService,
                          UserService $userService){

        Log::info($request->all());

        $v=Validator::make($request->all(),[
            'fullname'=>'required',
            'email'=>'required|email|unique:users,email',
            'character'=>[
                'required',
                Rule::in(['O','X'])
            ]
        ]);

        if($v->fails()){
            return $this->sendError($v->messages()->all(),200);
        }

        $email=$request->get('email');
        $fullname=$request->get('fullname');
        $character=$request->get('character');
        $computerXter=$character=='O'?'X':'O';

        DB::beginTransaction();
        try{
            $playerAccount=$userService->startGame($fullname,$email,$character,$computerXter);
            $board=$boardService->createBoard();

            $response=[
                'fullname'=>$fullname,
                'player_id'=>$playerAccount->id,
                'character'=>$playerAccount->character,
                'board'=>$board
            ];

//            DB::commit();
            return $this->sendResponse($response,'Game Started Successfully.',201);
        }
        catch(\Exception $ex){
            DB::rollBack();
            return $this->sendError($ex->getMessage(),500);
        }
    }


    public function move(Request $request){
        return $request->all();
    }
}
