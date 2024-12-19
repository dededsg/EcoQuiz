<?php

var_dump($_POST);
session_start();

if(isset($_POST['submit']) && !empty(trim($_POST['nome'])) && !empty(trim($_POST['matricula'])))
    {
    session_start();
    include_once('conexao.php');
    $matricula = $_POST['matricula'];
    $nome = $_POST['nome'];

    $stmt = $conn->prepare("SELECT id FROM usuario WHERE matricula = ? AND nome = ?");
    $stmt->bind_param("is", $matricula, $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows < 1) {
        unset($_SESSION['matricula']);
        unset($_SESSION['nome']);
        echo '<script type="text/javascript">';
        echo 'alert("Usuário ou senha incorretos!");';
        echo 'window.location.href = "login.html";';
        echo '</script>';
    } else {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['matricula'] = $matricula;
        $_SESSION['nome'] = $nome;
        header('Location: index.php');
        exit();
    }
    $stmt->close();
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Informe todos os campos!");';
    echo 'window.location.href = "login.html";';
    echo '</script>';
}
?>
