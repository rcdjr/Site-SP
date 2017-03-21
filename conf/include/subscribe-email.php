<?php

require_once('phpmailer/PHPMailerAutoload.php');

$toemails = array();

$toemails[] = array(
	'email' => 'contato@agenciaspcomunicacao.com.br', // Your Email Address
	'name' => 'contato' // Your Name
			);

// Form Processing Messages
$message_success = 'Nós recebemos com <strong>sucesso</strong> sua mensagem, retornaremos o mais breve possivel.';

$mail = new PHPMailer();

// If you intend you use SMTP, add your SMTP Code after this Line


if( isset( $_POST['widget-subscribe-form-email'] ) ) {
	if( $_POST['widget-subscribe-form-email'] != '' ) {

		$email = $_POST['widget-subscribe-form-email'];

		$subject = 'Subscribe me to the List';

		$mail->SetFrom( $email , 'New Subscriber' );
		$mail->AddReplyTo( $email );
		foreach( $toemails as $toemail ) {
			$mail->AddAddress( $toemail['email'] , $toemail['name'] );
		}
		$mail->Subject = $subject;

		$email = isset($email) ? "Email: $email<br><br>" : '';

		$referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

		$body = "$email $referrer";

		$mail->MsgHTML( $body );
		$sendEmail = $mail->Send();

		if( $sendEmail == true ):
			echo '{ "alert": "success", "message": "' . $message_success . '" }';
		else:
			echo '{ "alert": "error", "message": "Email <strong>could not</strong> be sent due to some Unexpected Error. Please Try Again later.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '" }';
		endif;
	} else {
		echo '{ "alert": "error", "message": "Por favor verifique se todos os campos estão <strong>preenchidos</strong>." }';
	}
} else {
	echo '{ "alert": "error", "message": "An <strong>unexpected error</strong> occured. Please Try Again later." }';
}

?>
