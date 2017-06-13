@extends('layouts.app')
<style>
    /*控制文本框内图片显示大小*/
    .panel-body img{
        width: 100%;
    }
</style>
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                         @foreach($question->topics as $topic)
                          <a class="topic" href="/topic/{{$topic->id}}">{{ $topic->name }}</a>
                         @endforeach
                    </div>
                    <div class="panel-body">
                      {!! $question->body !!}
                    </div>
                    <div class="actions">
                        {{--判断用户是否登录并且必须是文章作者本人--}}
                          @if(Auth::check() && Auth::user()->owns($question))
                              <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            <form action="/questions/{{$question->id}}" method="post" class="delete-form">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                          @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
