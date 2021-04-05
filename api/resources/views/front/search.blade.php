@extends('layouts/default')
@section('title',$title)
@section('main')
    <x-article :article="$article" :pageNum="$pageNum" :page="$page"></x-article>
    <x-pagination-search :page="$page" :pageNum="$pageNum" route="search" :search="$search"></x-pagination-search>
@endsection

