<?php
session_start();

// Destruir todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login
header("Location: login.html");
exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <style>
        @font-face {
            font-family: 'Fira Code';
            src: url('fonts/FiraCode-Medium.ttf') format('truetype');
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #337045, #78c08e);
            font-family: 'Fira Code';
            color: white;
            overflow: hidden;
        }

        .title-table {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 20px;
            color: white;
            margin-top: 50px;
        }

    </style>
</head>

<body>
        <h2 class="title-table">Saindo...</h2>
</body>

</html>

