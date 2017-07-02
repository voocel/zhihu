<?php

namespace App\Http\Controllers;
use App\Repositories\QuestionRepository;

use Auth;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    protected $QuestionRepository;
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->QuestionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->QuestionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.make');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topics=$this->QuestionRepository->normalizeTopic($request->get('topics'));
        //获取到话题对应的id数组
        //dd($topics);
        $message=[
          'title.required'  =>  '标题不能为空',
          'title.min'  =>  '标题不能少于6位',
          'title.max'  =>  '标题不能多于30位',
            'body.required'    =>    '内容不能为空',
            'body.min'     =>    '内容不能少于20'
        ];
        $rules=[
            'title' => 'required|min:6|max:30',
            'body'  => 'required|min:20'
        ];
        $this->validate($request,$rules,$message);
        $data=[
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
            'user_id'=>Auth::id()
        ];
        //$question=Question::create($data);     优化使用QuestionRepository代替
        $question = $this->QuestionRepository->create($data);
        //将创建的问题记录关联到question_topic表,即创建topic和question的关联数据
        $question->topics()->attach($topics);
        return redirect()->route('questions.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //该‘topics’为Question类的方法
       // $question=Question::where('id',$id)->with('topics')->first();     优化使用QuestionRepository
        $question = $this->QuestionRepository->ByIdWithTopicsAndAnswers($id);
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->QuestionRepository->byId($id);
        //判断是不是作者本人编辑
        if(Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
           return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message=[
            'title.required'  =>  '标题不能为空',
            'title.min'  =>  '标题不能少于6位',
            'title.max'  =>  '标题不能多于30位',
            'body.required'    =>    '内容不能为空',
            'body.min'     =>    '内容不能少于20'
        ];
        $rules=[
            'title' => 'required|min:6|max:30',
            'body'  => 'required|min:20'
        ];
        $this->validate($request,$rules,$message);
        $topics=$this->QuestionRepository->normalizeTopic($request->get('topics'));
        $question = $this->QuestionRepository->byId($id);
        $question->update([
            'title'   => $request->get('title'),
            'body'    => $request->get('body'),
        ]);
        $question->topics()->sync($topics);
        return redirect()->route('questions.show',[$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->QuestionRepository->byId($id);
        if(Auth::user()->owns($question)){
            $question->delete();
            return redirect('/');
        }
        abort(403,'Forbidden');  //return back()
    }

    //如果话题存在就会返回该话题的id如果不存在就是创建新的话题，
    //需要通过此方法获取ID，否则会是话题名称，而无法关联其他表
//    public function normalizeTopic(array $topics)       (使用QuestionRepository优化代替)
//    {
//       return collect($topics)->map(function ($topic){
//              if(is_numeric($topic)){
//                  //若话题存在，则在相应的话题的questions_count加1
//                  Topic::find($topic)->increment('questions_count');
//                  return (int) $topic;
//              }
//              $newTopic=Topic::create(['name'=>$topic,'questions_count'=>1]);
//              return $newTopic->id;
//        })->toArray();
//    }
}
