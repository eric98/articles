@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Articles
@endsection


@section('main-content')
    <form action="/articles_php/{{ $article->id }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="btn-group">
            <a href="/articles_php" class="btn btn-success" role="button" aria-disabled="true"> < Back</a>
            <a href="/articles_php/edit/{{ $article->id}}" class="btn btn-warning" role="button" aria-disabled="true">Edit</a>
            <button type="submit" class="btn btn-danger">Delete</button>
        </div>
    </form>


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Task:</h3>
        </div>
        <div class="box-body">
            <ul>
                <li>Id: {{ $article->id }}</li>
                <li>Title: {{ $article->title }}</li>
                <li>Description: {{ $article->description }}</li>
                <li>Status: {{ $article->completed?'Completed':'Pending' }}</li>
                <li>User_id: {{ $article->user_id }}</li>
                <li>User name: {{ App\User::findOrFail($article->user_id)->name }}</li>
            </ul>
        </div>
    </div>
@endsection