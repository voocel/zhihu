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
                    <div class="panel-heading">{{$question->title}}</div>

                    <div class="panel-body">
                      {!! $question->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
