@extends('layouts.app')
<style>
    /*控制文本框内图片显示大小*/
    .panel-body img{
        width: 100%;
    }
</style>
@section('content')
    @include('vendor.ueditor.assets')
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
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                          {{ $question->answers_count }}个答案
                    </div>
                    <div class="panel-body">
                        <form action="/questions/{{$question->id}}/answer" method="post">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                                <script style="height: 120px;" id="container" name="body" type="text/plain">
                                    {!! old('body') !!}
                                </script>
                                @if ($errors->has('body'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                        @endif
                            </div>

                                    <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                     </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                        @section('js')
                                    <!-- 实例化编辑器 -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                                <script type="text/javascript">
                                    var ue = UE.getEditor('container',{
                                        toolbars: [
                                            ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                                        ],
                                        elementPathEnabled: false,
                                        enableContextMenu: false,
                                        autoClearEmptyNode:true,
                                        wordCount:false,
                                        imagePopup:false,
                                        autotypeset:{ indent: true,imageBlockLine: 'center' }
                                    });
                                    ue.ready(function() {
                                        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                                    });
                                    //ajax 请求话题
                                    $(document).ready(function () {
                                        function formatTopic (topic) {
                                            return "<div class='select2-result-repository clearfix'>" +
                                            "<div class='select2-result-repository__meta'>" +
                                            "<div class='select2-result-repository__title'>" +
                                            topic.name ? topic.name : "Laravel"   +
                                                "</div></div></div>";
                                        }
                                        function formatTopicSelection (topic) {
                                            return topic.name || topic.text;
                                        }
                                        $(".js-example-placeholder-multiple").select2({
                                            tags: true,
                                            placeholder: '选择相关话题',
                                            minimumInputLength: 2,
                                            ajax: {
                                                url: '/api/topics',
                                                dataType: 'json',
                                                delay: 250,
                                                data: function (params) {
                                                    return {
                                                        q: params.term
                                                    };
                                                },
                                                processResults: function (data, params) {
                                                    return {
                                                        results: data
                                                    };
                                                },
                                                cache: true
                                            },
                                            templateResult: formatTopic,
                                            templateSelection: formatTopicSelection,
                                            escapeMarkup: function (markup) { return markup; }
                                        });
                                    })

                                </script>

                            @endsection
                            <!-- 编辑器结束 -->
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
@section('js')
    <!-- 实例化编辑器 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

@endsection
@endsection
