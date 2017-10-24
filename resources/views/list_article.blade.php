<h1>Articles:</h1>
@foreach ($articles as $article)
    <ul>
        <li>Title: {{ $article->title }}</li>
        <li>Description: {{ $article->description }}</li>
    </ul>
@endforeach

{{ $status or '' }}