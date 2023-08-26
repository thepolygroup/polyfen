<?php
  $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
  $recaptcha_secret = '6Lej_NMnAAAAAA_cHM65NQgTnibELPKC5GRRx2ht';
  $response = $_POST['g-recaptcha-response'];
  $error = "";

  $json = json_decode(file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $response), true);

  //send email if OK
  if ($json['success']) {
    $to = "hp.hernanpereira@gmail.com";
    $subject = "Contact Form POLYFEN TEST";
    $body = "";

    foreach ($_POST as $k=>$v) {
      if ($k != "g-recaptcha-response") {
        $body .= "$k : $v\r\n";
      }
    }

    if (!mail($to, $subject, $body)){
      $error = "Falla en enviar email";
    }

    // Output result OK
    http_response_code(200);
    echo json_encode(array("message" => "Mensaje enviado con éxito"));
  } else { 
    $error = "Captcha Inválido";

    // Output result ERROR
    http_response_code(400);
    echo json_encode(array("message" => $error));
  }
?>
