<!DOCTYPE html>
<html>
<head>
    <title>Start Data Collection</title>
</head>
<body>
    <h1>Start Data Collection</h1>
    <form method="POST" action="/start-data-collection">
        @csrf
        <label for="id_user">User ID:</label>
        <input type="text" id="user_id" name="user_id" required>
        <button type="submit">Start Collection</button>
    </form>
</body>
</html>
