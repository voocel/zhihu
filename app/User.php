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
//判断是不是作者本人
    public function owns(Model $model){
          return $this->id == $model->user_id;
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
