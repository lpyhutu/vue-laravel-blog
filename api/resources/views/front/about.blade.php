@extends('layouts/default')
@section('title',$title)
@section('main')
    {!! editor_css() !!}
    {!! editor_js() !!}
    <div class="ht-about">
        <div id="a-text" style="display:none;">{{$info[0]->content}}</div>
        <div id="test-editormd-view">
            <textarea id="append-test" style="display:none;"></textarea>
        </div>
    </div>
    <script>
        $(function () {
            let testEditormdView;
            testEditormdView = editormd.markdownToHTML("test-editormd-view", {
                markdown: $("#a-text").text(),
                htmlDecode: "style,script,iframe",
                tocm: true,
                emoji: true,
                taskList: true,
                tex: true,
                flowChart: true,
                sequenceDiagram: true,
            });
        })
    </script>
    <style>
        .ht-about {
            padding: 10px;
            background: #fff;
        }
    </style>
@endsection


