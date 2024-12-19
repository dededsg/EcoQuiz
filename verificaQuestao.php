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

?>

<?php

if (isset($_POST['submit']) && !empty($_POST['quiz']) && !empty($_POST['questaoId'])) {
    $alternativa = $_POST['quiz'];
    $questaoId = $_POST['questaoId'];
    $resposta = $_POST['resposta'];
    $explicacao = $_POST['explicacao'];
    $idUser = $_SESSION['id'];

    // Verificar se a pergunta já foi respondida
    if (!isset($_SESSION['answered_' . $questaoId])) {

        if ($resposta == $alternativa) {
            // Marcar que a pergunta foi respondida
            $_SESSION['answered_' . $questaoId] = true;

            // Atualizar ou inserir a pontuação no banco
            $sqlCheck = "SELECT COUNT(*) FROM ranking WHERE id_usuario = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("i", $idUser);
            $stmtCheck->execute();
            $stmtCheck->bind_result($exists);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($exists > 0) {
                // Incrementa o ponto
                $sqlUpdate = "UPDATE ranking SET ponto = ponto + 1 WHERE id_usuario = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param("i", $idUser);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            } else {
                // Inserir no ranking
                $sqlInsert = "INSERT INTO ranking (id_usuario, ponto) VALUES (?, 1)";
                $stmtInsert = $conn->prepare($sqlInsert);
                $stmtInsert->bind_param("i", $idUser);
                $stmtInsert->execute();
                $stmtInsert->close();
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questão</title>
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
            background: linear-gradient(135deg, #337045, #78c08e);
            overflow: hidden;
            font-family: "Fira Code";
        }

        .feedback-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 20px;
        }
        .feedback-enunciado{
            display: flex;
        }

        .enunciado-verdadeiro {
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #245826;
        }
        .ponto {
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #245826;
            margin-left: auto;
        }

        .enunciado-falso {
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #991e1e;
        }

        .explicação {
            font-size: 1em;
            color: #000000;
        }

        .buttons {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
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

        a {
            text-decoration: none;
        }

        .button:hover {
            background-color: #4caf50;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="feedback-container">
        <div class="feedback-enunciado">
        <?php     
            if($resposta == $alternativa){
                ?>  
                    <source src="videoplayback(1).m4a" type="audio/mpeg">
                    <h3 class="enunciado-verdadeiro">Parabéns! você acertou!!! :)</h3>
                    <h3 class="ponto">+1 ponto</h3>

                <?php
            }else{
                ?>  
                    
                    <h3 class="enunciado-falso">Não foi dessa vez :(</h3>
                <?php
            }
        ?>
        </div>

        <p class="explicacao">
            <?php echo ($explicacao); ?>
        </p>

        <div class="buttons">
            <a href="questao.php">
                <div class="button">Jogar</div>
            </a>
            <a href="ranking.php">
                <div class="button">Ranking</div>
            </a>
        </div>
    </div>

    <script>
        let mouseX = 0.5;
        let mouseY = 0.5;
        let time = 0;

        document.body.addEventListener("mousemove", (event) => {
            mouseX = event.clientX / window.innerWidth;
            mouseY = event.clientY / window.innerHeight;
        });

        function animateBackground() {
            time += 0.04;

            const r1 = Math.round(51 + (120 - 51) * (Math.sin(time + mouseX) * 0.5 + 0.5));
            const g1 = Math.round(112 + (192 - 112) * (Math.sin(time + mouseY) * 0.5 + 0.5));
            const b1 = Math.round(69 + (142 - 69) * (Math.cos(time + mouseX) * 0.5 + 0.5));

            const r2 = Math.round(51 + (120 - 51) * (Math.cos(time + mouseY) * 0.5 + 0.5));
            const g2 = Math.round(112 + (192 - 112) * (Math.cos(time + mouseX) * 0.5 + 0.5));
            const b2 = Math.round(69 + (142 - 69) * (Math.sin(time + mouseY) * 0.5 + 0.5));

            const color1 = `rgb(${r1}, ${g1}, ${b1})`;
            const color2 = `rgb(${r2}, ${g2}, ${b2})`;

            document.body.style.background = `linear-gradient(135deg, ${color1}, ${color2})`;

            requestAnimationFrame(animateBackground);
        }

        animateBackground();
    </script>
</body>
</html>