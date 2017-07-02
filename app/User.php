<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;
use Mail;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function answers(){
        return $this->hasMany(Answer::class);
    }

//判断是不是作者本人
    public function owns(Model $model){
          return $this->id == $model->user_id;
    }

    //创建一条记录,就把两个id关联起来了
    public function follows(){
//        return Follow::create([
//            'question_id' => $question,
//            'user_id'     => $this->id
//        ]);
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    //toggle方法，数据库中存在就删除，不存在就创建
    public function followThis($question){
        return $this->follows()->toggle($question);
    }

    //查看是否已经关注该问题，查到记录返回true没有查到返回false
    public function followed($question){
        return $this->follows()->where('question_id',$question)->count();
    }


    public function sendPasswordResetNotification($token)
    {
        $bind_data = ['url' => url('password/reset',$token)
        ];
        $template = new SendCloudTemplate('resetpassword', $bind_data);

        Mail::raw($template, function ($message) {
            $message->from('voocel@163.com', 'VOOCEL');

            $message->to($this->email);
        });
    }


}
