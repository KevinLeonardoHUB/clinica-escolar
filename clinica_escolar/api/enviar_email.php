<?php
// Aqui importo as classes necessárias do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Aqui importo os ficheiros da biblioteca PHPMailer que estão dentro da pasta lib
require __DIR__ . '/../lib/PHPMailer/src/Exception.php';
require __DIR__ . '/../lib/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../lib/PHPMailer/src/SMTP.php';

// Aqui crio uma função para enviar emails de forma simples em qualquer parte do projeto
function enviarEmail($destino, $nome, $assunto, $corpoHtml) {

    // Aqui crio um novo objeto PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Aqui defino a codificação correta para acentos
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';

        // Aqui digo ao PHPMailer que vou usar SMTP
        $mail->isSMTP();

        // Aqui configuro o servidor de envio por variáveis de ambiente.
        // Nunca coloque senhas diretamente no código antes de enviar para o GitHub.
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.sapo.pt';
        $mail->Port = getenv('SMTP_PORT') ?: 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USER') ?: '';
        $mail->Password = getenv('SMTP_PASS') ?: '';
        $mail->setFrom(getenv('SMTP_FROM') ?: $mail->Username, getenv('SMTP_FROM_NAME') ?: 'Clínica Eduga');

        // Aqui adiciono o destinatário
        $mail->addAddress($destino, $nome);

        // Aqui digo que o email será em HTML
        $mail->isHTML(true);

        // Aqui defino o assunto e o conteúdo
        $mail->Subject = $assunto;
        $mail->Body    = $corpoHtml;

        // Aqui tento enviar o email
        $mail->send();
        return true;

    } catch (Exception $e) {
        // Se der erro, mostro a mensagem
        echo "Erro ao enviar email: " . $mail->ErrorInfo;
        return false;
    }
}
