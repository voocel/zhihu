<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class QuestionFollowController extends Controller
{
    public function __construct()
    {
        //需要登录才可以访问该控制器里的方法
        $this->middleware('auth');
    }

    //调用user模型里的follows方法
    public function follow($question){
        Auth::user()->followThis($question);
        return back();
    }
}
