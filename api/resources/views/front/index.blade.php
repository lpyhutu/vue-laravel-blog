@extends('layouts/default')
@section('title',$title)
@section('main')
    <x-article :article="$article" :pageNum="$pageNum" :page="$page"></x-article>
    <x-pagination :page="$page" :pageNum="$pageNum" route="page"></x-pagination>
@endsection

