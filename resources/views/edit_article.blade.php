<h1>Edit Article:</h1>

<ul>
    <li>Title: {{ $article->title }}</li>
    <li>Description: {{ $article->description }}</li>
</ul>

<form action="/articles/show" method="GET">
    {{ csrf_field() }}
    Title: <input type="text" name="title">
    Description: <input type="description" name="description">
    <button type="submit">Edit</button>
</form>