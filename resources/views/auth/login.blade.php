<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="email" placeholder="email" id="email" required>
                <i class='bx bxs-envelope'></i>
                <span id="email_error" class="error"></span>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="mot de passe" id="password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button type="submit" class="btn" id="submitButton" disabled>Connexion</button>
        </form>
        <div class="reponse" id="response"></div>
    </div>
    <script src="{{ asset('js/scriptconnexion.js') }}"></script>
</body>

</html>
