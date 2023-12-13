<?php

// configure
$from = 'Nova mensagem de contato <contato@paispelosfilhos.com.br>';
$sendTo = 'Contato <lucas_rc15@live.com>'; // Add Your Email
$subject = 'Nova mensagem do formulário de contato';
$fields = array('name' => 'Nome', 'subject' => 'Assunto', 'email' => 'E-mail', 'message' => 'Mensagem'); // array variable name => Text to appear in the email
$okMessage = 'Formulário enviado com sucesso. Obrigado, em breve retornaremos o contato. :)';
$errorMessage = 'Ocorreu um erro ao enviar o formulário. Por favor, tente novamente mais tarde.';

// let's do the sending

try
{
    $emailText = "Você tem uma nova mensagem do formulário para contato!\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
