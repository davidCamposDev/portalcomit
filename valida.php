<?php session_start();

 require('conexao.php');

if (isset($_POST['email_user']) || isset($_POST['senha_user'])) {

    $email_user = $mysqli->real_escape_string($_POST['email_user']);
    $senha_user = $mysqli->real_escape_string($_POST['senha_user']);

    //codigo para verificar o login e senha no banco de dados
    $sql_code = "SELECT * FROM usuario WHERE email_user = '$email_user' AND senha_user = '$senha_user'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    //verificar se a quantidade de registros e 1
    $quantidade = $sql_query->num_rows;

    if ($quantidade == 1) {

        $usuario = $sql_query->fetch_assoc();
        if (!isset($_SESSION)) {
            session_start();
        }

        //manter sessao 

        $_SESSION['nome_user'] = $usuario['nome_user'];
        $_SESSION['rg_user'] = $usuario['rg_user'];
        $_SESSION['email_user'] = $usuario['email_user'];
        $_SESSION['tipo_login'] = $usuario['tipo_login'];

        if ($_SESSION['tipo_login'] == 1) {

            echo "<script> alert('Administrador [LOGADO]');</script>";
        
            header("Location: admin/index_adm.php");

        } else {

            echo "<script> alert('Usuario [LOGADO]');</script>";
           
            header("Location: index.php");

        }

    } else {
        echo "Falha ao logar! E-mail ou senha incorretos";
    }



}
?>