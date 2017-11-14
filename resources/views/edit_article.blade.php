@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Articles
@endsection


@section('main-content')
{{ Session::get('status') }}

<h1>Edit Article:</h1>

<form action="/articles/{{ $article->id }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    Title: <input type="text" name="title" placeholder="Put your title here" value="{{ $article->title }}" id="title">
    Description: <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here">{{ $article->description }}</textarea>
    <button type="submit">Update</button>
</form>

<form action="/articles" method="GET">
    <input type="submit" value="List Articles">
</form>
@endsection