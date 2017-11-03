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

<h1>Create Article:</h1>

<form action="/articles" method="POST">
    {{ csrf_field() }}
    Title: <input type="text" name="title" placeholder="Title" id="title">
    Description: <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here"></textarea>
    <input type="submit" value="Create">
</form>

<form action="/articles" method="GET">
    <input type="submit" value="List Articles">
</form>

</body>
</html>