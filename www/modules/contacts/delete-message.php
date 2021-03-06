<?php

if ( !isAdmin() ) {
	header("Location: " . HOST);
	die();
}

$title = 'Удалить сообщение';

$message = R::load('messages', $_GET['id']);

if ( isset($_POST['deleteMessage'])) {

	R::trash($message);
	header('Location: ' . HOST . "messages?result==");
	exit();

}

ob_start();
include ROOT . 'views/pages/contacts/delete-message.tpl';
$content = ob_get_contents();
ob_end_clean();

include ROOT . 'views/parts/head.tpl';
include ROOT . 'views/parts/header.tpl';
include ROOT . 'views/template.tpl';
include ROOT . 'views/parts/footer.tpl';
include ROOT . 'views/parts/foot.tpl';

?>
