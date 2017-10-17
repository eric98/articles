<h1>Create Article:</h1>

<form action="/articles/create" method="POST">
    {{ csrf_field() }}
    Title: <input type="text" name="title">
    Description: <input type="description" name="description">
    <button type="submit">Add</button>
</form>