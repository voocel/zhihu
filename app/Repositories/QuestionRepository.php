<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 1:23
 */

namespace App\Repositories;
use App\Question;
use App\Topic;

class QuestionRepository
{
       public function ByIdWithTopics($id){

             return Question::where('id',$id)->with('topics')->first();
       }

       public function create(array $attributes){
              return Question::create($attributes);
       }

       public function normalizeTopic(array $topics){
           return collect($topics)->map(function ($topic){
               if(is_numeric($topic)){
                   //若话题存在，则在相应的话题的questions_count加1
                   Topic::find($topic)->increment('questions_count');
                   return (int) $topic;
               }
               $newTopic=Topic::create(['name'=>$topic,'questions_count'=>1]);
               return $newTopic->id;
           })->toArray();
       }

       public function byId($id){
           return Question::find($id);
       }

}