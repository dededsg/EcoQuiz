<?php
$dns = "mysql:dbname=ecoquiz;host=localhost"; 
$user = "root";
$pass = "";
$pdo = new PDO($dns, $user, $pass);        

$conn = mysqli_connect('localhost', 'root', '', 'ecoquiz');
if(mysqli_connect_errno()) {
    echo "Erro na conexão com o banco de dados";
    exit();
}
?>