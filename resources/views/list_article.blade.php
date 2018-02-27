@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Articles
@endsection


@section('main-content')
    @if (Session::get('status') )
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            {{ Session::get('status') }}
        </div>
    @endif

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Articles:</h3>
        </div>

        <div class="box-header with-border">
            <a href="/articles_php/create" class="btn btn-success" role="button" aria-disabled="true">Create Article</a>
        </div>
        </form>
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <tbody>
                <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 10px">Id</th>
                    <th style="width: 500px">Article</th>
                    <th style="width: 500px">Description</th>
                    <th style="width: 10px">Status</th>
                    <th style="width: 10px">User_Id</th>
                    <th style="width: 200px">User Name</th>
                    <th style="width: 200px">Actions</th>
                </tr>

                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $article->id}}</td>
                        <td>{{ $article->title }}</td>
                        <td>{!! $article->description !!}</td>
                        <td>{{ $article->completed?'Completed':'Pending' }}</td>
                        <td>{{ $article->user_id }}</td>
                        <td>{{ App\User::findOrFail($article->user_id)->name }}</td>

                        <td>
                            <form action="/articles_php/{{ $article->id }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="btn-group">
                                    <a id="completed-article-{{ $article->id}}" href="/articles_php/statuschance/{{ $article->id}}" class="btn btn-success" role="button" aria-disabled="true">{{ $article->completed?'To do':'Complete' }}</a>
                                    <a id="show-article-{{ $article->id}}" href="/articles_php/{{ $article->id}}" class="btn btn-info" role="button" aria-disabled="true">Show</a>
                                    <a id="edit-article-{{ $article->id}}" href="/articles_php/edit/{{ $article->id}}" class="btn btn-warning" role="button" aria-disabled="true">Edit</a>
                                    <button id="delete-article-{{ $article->id}}" type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection