<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$bd = "site_materiais";

// Conectar ao banco
$conn = new mysqli($host, $usuario, $senha, $bd);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Pegar os dados do formulário
$nome = $_POST['name'];
$email = $_POST['email'];
$assunto = $_POST['subject'];
$mensagem = $_POST['message'];

// Inserir no banco
$sql = "INSERT INTO mensagens_contato (nome, email, assunto, mensagem)
        VALUES ('$nome', '$email', '$assunto', '$mensagem')";

if ($conn->query($sql) === TRUE) {
    header("Location: obrigado.html");
exit();
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
