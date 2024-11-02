<!DOCTYPE html>
<html lang="en">

<head>
    <title>signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>signup</h1>
    <div class= "d-flex"></div>
    <form method="post" action="{{ route('auth.signup') }}">
        @csrf
        <label for="name">Name:</label>
        <input name="name">

        <label for="email">Email</label>
        <input name="email">

        <label for="password">password</label>
        <input name="password">

        <button type="submit">signup</button>
    </form>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</body>

</html>
