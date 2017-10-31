<h1>Articles:</h1>

{{ Session::get('status') or '' }}
{{--{{ Session::get('status') }}--}}

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