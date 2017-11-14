@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Articles
@endsection


@section('main-content')
    <h1>Article:</h1>

    <ul>
        <li>Title: {{ $article->title }}</li>
        <li>Description: {{ $article->description }}</li>
    </ul>

    <form action="/articles" method="GET">
        <input type="submit" value="List Articles">
    </form>
@endsection