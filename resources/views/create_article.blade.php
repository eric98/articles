@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Articles
@endsection


@section('main-content')


{{ Session::get('status') }}

<h1>Create Article:</h1>

<form action="/articles" method="POST">
    {{ csrf_field() }}
    Title: <input type="text" name="title" placeholder="Title" id="title">
    Description: <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here"></textarea>
    <input type="submit" value="Create">
</form>

<form action="/articles_php" method="GET">
    <input type="submit" value="List Articles">
</form>

@endsection