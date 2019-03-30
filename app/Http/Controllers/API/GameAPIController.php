<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repository\Eloquents\PlayerRepository;
use App\Repository\Eloquents\UserRepository;
use App\Service\BoardService;
use App\Service\BotService;
use App\Service\GameService;
use App\Service\PlayerService;
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


    public function move(Request $request,
                         BoardService $boardService,
                         PlayerRepository $playerRepository,
                         PlayerService $playerService,
                         BotService $botService
    ){
        $v=Validator::make($request->all(),[
           'player_id'=>'required|exists:players,id',
            'x'=>'required|numeric|min:0|max:2',
            'y'=>'required|numeric|min:0|max:2',
            'board'=>'required'
        ]);

        if($v->fails()){
            return $this->sendError($v->messages()->all());
        }

        $board=$request->board;
        $player=$playerRepository->find($request->player_id);

        Log::info($request->all());


        DB::beginTransaction();
        try{

            $playerService->makeMove($player->id,$request->x,$request->y);
            //check if this move leads to winning.
            $winning=$boardService->verifyWinning($board);
            if($winning['found']){
                //means there is a winning
                if($winning['winner']===$player->character){
                    return $this->sendResponse([
                        'finished'=>true,
                    ],"You Win");
                }else{
                    return $this->sendResponse([
                        'finished'=>true,
                    ],"Computer Wins");
                }
            }

            //lets check if there is more space to play.
            if($boardService->isBoardFilled($board)){
                return $this->sendResponse([
                    'finished'=>true
                ],"There is a draw.");
            }

//            $oldBoard=$board;
            //lets get the bot player on here.
            $botPlayer=$playerService->getBotPlayer($player->game_id);
            $newBotPlay=$botService->play($botPlayer->game_id,$board);

            $newBoard=$newBotPlay['board'];
//            return $newBoard;

            $winning=$boardService->verifyWinning($newBoard);
            if($winning['found']){
                //means there is a winning
                if($winning['winner']===$player->character){
                    return $this->sendResponse([
                        'finished'=>true,
                    ],"You Win");
                }else{
                    return $this->sendResponse([
                        'finished'=>true,
                    ],"Computer Wins");
                }
            }

            //lets check if there is more space to play.
            if($boardService->isBoardFilled($newBoard)){
                return $this->sendResponse([
                    'finished'=>true
                ],"There is a draw.");
            }

            $response=[
                'finished'=>false,
                'board'=>$newBoard
            ];

            return $this->sendResponse($response,'Your Turn...');
        }
        catch (\Exception $ex){
            DB::rollBack();
            Log::info($ex);
            return $this->sendError($ex->getMessage(),500);
        }
    }
}
