<h1>Articles:</h1>

<form action="/articles/create" method="GET">
    <input type="submit" value="Create an article">
</form>

{{ Session::get('status') }}

@foreach ($articles as $article)
    <ul>
        <li>Title: {{ $article->title }}</li>
        <li>Description: {{ $article->description }}</li>
        <li><form action="/articles/{{ $article->id }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" value="delete">
            </form>
        </li>
    </ul>
@endforeach

{{ $status or '' }}