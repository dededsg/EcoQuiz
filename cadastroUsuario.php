
<?php
include_once('conexao.php');

if(isset($_POST['submit']) && !empty($_POST['nome']) && !empty($_POST['matricula']))
{
    
    //cadastrar
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];

    $sql = "SELECT * FROM usuario WHERE matricula = '$matricula'";


    $result = $conn->query($sql);
    if(mysqli_num_rows($result) < 1)
    {

        $sql = "INSERT INTO usuario (matricula, nome) VALUES ('$matricula', '$nome')";
        

        mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn) > 0) {
            echo '<script type="text/javascript">'; 
            echo 'alert("Cadastro concluído com sucesso!");'; 
            echo 'window.location.href = "cadastro.html";';
            echo '</script>';
        }
        mysqli_close($conn);         
    }
    else
    {
        mysqli_close($conn);
        
        echo '<script type="text/javascript">';       
        echo 'alert("Essa matricula já foi cadastrada!");'; 
        echo 'window.location.href = "cadastro.html";';
        echo '</script>';
    }
 }
 else   
 {
     //não cadastra
     mysqli_close($conn);    
     echo '<script type="text/javascript">'; 
     echo 'alert("Informe todos os campos!");'; 
     echo 'window.location.href = "cadastro.html";';
     echo '</script>';
 }

?>
