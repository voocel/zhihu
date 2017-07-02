<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];


    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function followers(){
        return $this->belongsToMany(User::class,'user_question')->withTimestamps();
    }

     //判断是不是隐藏的可不可以发布到首页
    public function scopePublished($query){
         return $query->where('is_hidden','F');
    }
}