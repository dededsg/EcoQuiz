<?php
session_start();
include_once('conexao.php'); // Inclua a conexão com o banco de dados

// Verifica se a sessão está ativa
if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];

    // Verifica se o usuário existe no banco de dados
    $sql = "SELECT id FROM usuario WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->store_result();

    // Se não encontrar o usuário no banco, redireciona para o login
    if ($stmt->num_rows == 0) {
        header("Location: login.html");
        exit();
    }

    $stmt->close();
} else {
    // Se não houver sessão, redireciona para o login
    header("Location: login.html");
    exit();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        @font-face {
            font-family: 'Fira Code';
            src: url('fonts/FiraCode-Medium.ttf') format('truetype');
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: Arial, sans-serif;
            color: white;
            overflow: hidden;
            background: url("imgs/fundogif.gif") no-repeat center center;
            background-size: cover;
            font-family: "Fira Code";
        }

        h1 {
            font-size: 3rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            
        }

        .buttons {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
        }

        .button {
            width: 150px;
            padding: 15px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            
        }
        
        a{
            text-decoration: none;
        }

        .button:hover {
            background-color: #4caf50;
            transform: scale(1.05);
        }

        .button-sair {
            width: 150px;
            padding: 15px;
            text-align: center;
            font-size: 1.2rem;
            margin-top: 20px;
            font-weight: bold;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }

        .button-sair:hover {
            background-color: #af4c4c;
            transform: scale(1.05);
        }

        img {
            width: 75px;
            height: 75px;
        }

    </style>
</head>

<body>
    <div class="buttons">
        
        <img src="imgs/logo.png" alt="Logo">
        <h1>EcoQuiz</h1>    
    </div>

    <div class="buttons">
        <a href="questao.php"><div class="button">Jogar</div></a>
        <a href="ranking.php"><div class="button">Ranking</div></a>
    </div>
    <div class="button-sair" onclick="window.location.href='sair.php';">Sair</div>
</body>

</html>