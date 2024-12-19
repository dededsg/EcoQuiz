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

if (isset($_SESSION['id'])) {
    // Limpa as variáveis específicas da sessão
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, 'answered_') === 0) {
            unset($_SESSION[$key]);
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

        .questao-container {
            background-color: #ffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 20px;
        }

        .enunciado {
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #245826;
        }

        .comando {
            font-size: 0.9em;
            color: #367938;
            margin-bottom: 15px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #245826;
            border-radius: 5px;
            background-color: #4fa152;
            color: white;
            font-size: 1em;
            cursor: pointer;
        }

        select:focus {
            outline: none;
            border-color: #4caf50;
        }

        .button {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-resposta {
            width: 200px;
            background: linear-gradient(to right, #346e39 0%, #020702 100%);
            background-size: 200% 100%;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-position 0.4s ease, transform 0.2s ease;
        }

        .btn-resposta:hover {
            background-position: -100% 0;
            transform: scale(1.05);
        }
        .buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .button-submit {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 50px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            border: none; /* Remove borda padrão */
        }
        .button-submit:hover {
            background-color: rgba(0, 0, 0, 0.9);
            transform: scale(1.05);
        }
        .alternativa-f {
    display: flex;
    align-items: center; /* Centraliza a bolinha com o texto */
    margin-bottom: 15px; /* Espaçamento entre as alternativas */
    font-size: 1em;
    color: #245826;
    cursor: pointer; /* Faz com que o cursor mude para indicar que é clicável */
}

.alternativa-f input[type="radio"] {
    appearance: none; /* Remove o estilo padrão */
    width: 20px; /* Tamanho da bolinha */
    height: 20px;
    border: 2px solid #245826; /* Cor da borda */
    border-radius: 50%; /* Torna o formato circular */
    outline: none;
    cursor: pointer;
    transition: 0.3s ease-in-out;
    background-color: white;
    margin-right: 10px; /* Espaçamento entre a bolinha e o texto */
}

.alternativa-f input[type="radio"]:checked {
    background-color: #4fa152; /* Cor ao selecionar */
    border-color: #4caf50;
    box-shadow: 0 0 10px rgba(79, 161, 82, 0.6);
}

.alternativa-f input[type="radio"]:hover {
    transform: scale(1.2); /* Aumenta levemente ao passar o mouse */
    border-color: #4caf50;
}


    </style>
</head>

<body>
    <div class="questao-container">
    <?php
        include_once('conexao.php');

        try {
            $sql = "SELECT * FROM questao ORDER BY RAND() LIMIT 1";
        
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($resultado) {
        ?>
        <h3 class="enunciado"><?php echo htmlspecialchars($resultado['enunciado']); ?></h3>
            </br>
        <form action="verificaQuestao.php" method="POST" class="form-questao" id="myForm">
        <div class="alternativa">
    <label class="alternativa-f">
        <input type="radio" name="quiz" value="1" required>
        <span><?php echo $resultado['q1']; ?></span>
    </label>
    <label class="alternativa-f">
        <input type="radio" name="quiz" value="2" required>
        <span><?php echo $resultado['q2']; ?></span>
    </label>
    <label class="alternativa-f">
        <input type="radio" name="quiz" value="3" required>
        <span><?php echo $resultado['q3']; ?></span>
    </label>
    <label class="alternativa-f">
        <input type="radio" name="quiz" value="4" required>
        <span><?php echo $resultado['q4']; ?></span>
    </label>
</div>
            <input type="hidden" name="questaoId" value="<?php echo $resultado['id']; ?>">
            <input type="hidden" name="resposta" value="<?php echo $resultado['resposta']; ?>">
            <input type="hidden" name="explicacao" value="<?php echo $resultado['explicacao']; ?>">


            <div class="buttons">
            <input type="submit" name="submit" value="Enviar" class="button-submit">
        </div>
        </form>
        <?php
    } else {
                echo "Nenhum cadastro encontrado.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        ?>
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