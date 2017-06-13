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
     //判断是不是隐藏的可不可以发布到首页
    public function scopePublished($query){
         return $query->where('is_hidden','F');
    }
}