<?php

$title = "Вход на сайт";

if (isset($_POST['login'])) {

  if ( trim($_POST['email']) == '' ) {
		$errors[] = ['title' => 'Введите Email'];
	}

	if ( trim($_POST['password']) == '') {
		$errors[] = ['title' => 'Введите Пароль' ];
	}

  if(!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['email'])) {
    $errors[] = ['title' => 'Неверное написание email'];
  } else if (!R::count('users', 'email = ?', array($_POST['email']) ) > 0 ) {
    $errors[]  = [
            'title' => 'Пользователь не найден',
            'desc' => $_POST['email'] . '<p> не зарегистрирован</p>',
          ];
    }

	if ( empty($errors)) {
    $user = R::findOne('users', 'email = ?', array($_POST['email']));

    if ($user) {
      if (password_verify($_POST['password'], $user->password)) {
        $_SESSION['logged_user'] = $user;
        $_SESSION['login'] = "1";
        $_SESSION['role'] = $user->role;

        if ( isset($_POST['rememberMe']) ) {
					ini_set('session.gc_maxlifetime', 31104000); // 60*60*24*30*12 = 1 год
					ini_set('session.cookie_lifetime', 31104000);
				}

				// Сравнение и обновление корзины вынесено в отдельный файл
				require ROOT . "modules/cart/cart-update-in-login.php";

        header("Location: " . HOST);
        exit();
      } else {
        $errors[] = ['title' => 'Пароль введен неверно'];
      }
    }
  }
}

// central part content
ob_start();
include ROOT . 'views/pages/login/form-login.tpl';
$content = ob_get_contents();
ob_end_clean();

include ROOT . 'views/parts/head.tpl';
include ROOT . 'views/pages/login/login-page.tpl';
include ROOT . 'views/parts/foot.tpl';

?>
