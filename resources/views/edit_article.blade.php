<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

{{ Session::get('status') }}

<h1>Edit Article:</h1>

<form action="/articles/{{ $article->id }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    Title: <input type="text" name="title" placeholder="Put your title here" value="{{ $article->title }}" id="title">
    Description: <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here">{{ $article->description }}</textarea>
    <button type="submit">Update</button>
</form>

</body>
</html>