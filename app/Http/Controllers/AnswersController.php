<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;
class AnswersController extends Controller
{
    protected $answer;
    public function __construct(AnswerRepository $answer)
    {
        $this->answer=$answer;
    }
    //提交每个问题下的回答
    //在这里使用自定义的request来注入（验证了body）
    public function store(StoreAnswerRequest $request,$question){
          $answer= $this->answer->create([
              'question_id' => $question,
              'user_id'     => Auth::id(),
              'body'        => $request->get('body')
          ]);
          //每次回答都要更新answer_count的值
          $answer->question()->increment('answers_count');
          return back();
    }
}
