<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supervisão";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$nome = isset($_POST['nome']) ? $conn->real_escape_string($_POST['nome']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$mensagem = isset($_POST['mensagem']) ? $conn->real_escape_string($_POST['mensagem']) : '';

if (empty($nome) || empty($email) || empty($mensagem)) {
    die("Por favor, preencha todos os campos.");
}

$sql = "INSERT INTO orcamentos (nome, email, mensagem) VALUES ('$nome', '$email', '$mensagem')";
if (!$conn->query($sql)) {
    die("Erro ao salvar no banco: " . $conn->error);
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lietsonsilvam@gmail.com'; // seu email
    $mail->Password = 'qnkp byjf huvz wglz'; // sua senha de app (com aspas)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('lietsonsilvam@gmail.com', 'CONSTRUCENTER'); // seu email
    $mail->addAddress('lietsonsilvam@gmail.com'); // onde receberá o email

    $mail->isHTML(false);
    $mail->Subject = 'Novo Pedido de Orcamento de Supervisão de Obras Industriais';
    $mail->Body = "Nome: $nome\nEmail: $email\nMensagem:\n$mensagem";

    $mail->send();

   echo '<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Orçamento Enviado</title>
    <link rel="stylesheet" href="static/css/boostrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            Orçamento enviado com sucesso! Entraremos em contato em breve.
        </div>
        <a href="serviços.html" class="btn btn-primary">Voltar à Página Serviços</a>
    </div>
</body>
</html>';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}

$conn->close();
?>