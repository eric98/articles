@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Articles
@endsection


@section('main-content')
    <div class="box">
        @if (Session::get('status') )
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{ Session::get('status') }}
            </div>
        @endif

        <div class="box-header with-border">
            <h3 class="box-title">Edit Article:</h3>
        </div>


        <div class="form-group">
            <form action="/articles_php/{{ $article->id }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="box-header with-border">
                    <label for="title">Title</label>
                    <input type="text" dusk="title" name="title" placeholder="Put your title here" value="{{ $article->title }}" id="title">
                </div>
                <div class="box-header with-border">
                    <label for="name">User</label>
                    <select name="user_id" id="user_id" class="form-control" dusk="user_id">
                        @foreach ($users as $user)
                            @if ( $article->user_id == $user->id )
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


                <div class="box-header with-border">
                    <button class="btn btn-warning" type="submit">Update</button>
                    <a href="/articles_php" class="btn btn-success pull-right" role="button" aria-disabled="true">List Articles</a>
                </div>
            </form>
        </div>
    </div>
@endsection