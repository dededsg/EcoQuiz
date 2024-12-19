<?php
session_start();
include_once('conexao.php');

if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];

    $sql = "SELECT id FROM usuario WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        header("Location: login.html");
        exit();
    }

    $stmt->close();
} else {
    header("Location: login.html");
    exit();
}

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

        img {
            float: left;
            transition: 500ms;
        }

        img:hover {
            transform: scale(1.2, 1.2);
            transition: 500ms;
            cursor: pointer;
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

        .ranking-container {
            width: 90%;
            max-width: 600px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }

        .title-table {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 20px;
            color: white;
            margin-top: 50px;
        }

        .ranking-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #245826;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .ranking-item:hover {
            transform: scale(1.03);
            background-color: #367938;
        }

        .ranking-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .ranking-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .ranking-position {
            font-size: 1.2rem;
            font-weight: bold;
            margin-right: 10px;
        }

        .ranking-username {
            font-size: 1rem;
            color: #b2d8b9;
        }

        .ranking-score {
            font-size: 1.2rem;
            font-weight: bold;
            color: #4caf50;
        }
    </style>
</head>

<body>
    <div class="ranking-container">
        <a href="index.php">
            <img src="imgs/icon-home.png" alt="Ícone de Casa">
        </a>
        <h2 class="title-table">Ranking</h2>

        <?php

        // Consulta para obter o ranking dos usuários
        $sql = "SELECT id_usuario, ponto FROM ranking ORDER BY ponto DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $posicao = 1;
            while ($row = $result->fetch_assoc()) {
                $idUsuario = $row['id_usuario'];
                $pontos = $row['ponto'];

                // Consulta para obter o nome do usuário
                $sqlUser = "SELECT nome FROM usuario WHERE id = ?";
                $stmtUser = $conn->prepare($sqlUser);
                $stmtUser->bind_param("i", $idUsuario);
                $stmtUser->execute();
                $stmtUser->bind_result($nomeUsuario);
                $stmtUser->fetch();
                $stmtUser->close();
        ?>
                <div class="ranking-item">
                    <div class="ranking-info">
                        <span class="ranking-position">
                            <?php echo $posicao; ?>
                        </span>
                        <span class="ranking-username">
                            <?php echo htmlspecialchars($nomeUsuario); ?>
                        </span>

                        <?php 
                        if ($posicao == 1) {
                            echo '<img src="imgs/ouro.png" alt="Medalha Ouro">';
                        } elseif ($posicao == 2) {
                            echo '<img src="imgs/prata.png" alt="Medalha Prata">';
                        } elseif ($posicao == 3) {
                            echo '<img src="imgs/bronze.png" alt="Medalha Bronze">';
                        }
                        ?>
                    </div>
                    <span class="ranking-score"><?php echo $pontos; ?></span>
                </div>
        <?php
                $posicao++;
            }
        } else {
            echo "Nenhum ranking encontrado.";
        }
        ?>
    </div>
</body>

</html>
