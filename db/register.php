<?php
require_once('db.php');
require_once('functions.php');

global $db;

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$get_email = $request->email;
$get_password = $request->password;
$get_login = $request->login;

$user_login = sanitize_text($get_login);
$get_password_hashed = password_hash($get_password, PASSWORD_DEFAULT);
$date = date("Y-m-d H:i:s");

if (!empty($user_login) and !empty($get_password) and !empty($get_email)) {

    $duplicate_email = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $duplicate_email->bindValue(':user_email', $get_email, PDO::PARAM_STR);
    $duplicate_email->execute();
    $duplicate_email = $duplicate_email->rowCount();

    $duplicate_login = $db->prepare('SELECT * FROM users WHERE user_login = :user_login');
    $duplicate_login->bindValue(':user_login', $user_login, PDO::PARAM_STR);
    $duplicate_login->execute();
    $duplicate_login = $duplicate_login->rowCount();

    $errors = 0;

    if ($duplicate_email != 0 && $duplicate_login != 0) {
        echo json_encode(array('email' => 1, 'login' => 1));
        $errors = 1;
    } else if ($duplicate_email != 0 && $duplicate_login == 0) {
        echo json_encode(array('email' => 1, 'login' => 0));
        $errors = 1;
    } else if ($duplicate_login == 0 && $duplicate_login != 0) {
        echo json_encode(array('email' => 1, 'login' => 0));
        $errors = 1;
    }
    if (!is_email($get_email)) {
        echo json_encode(array('email' => 1, 'login' => 0));
        $errors = 1;
    }

    if ($errors == 0) {
        $private_key = random_hash();

        global $db;
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $db->prepare("INSERT INTO users (user_email, user_login, user_password, user_registered, user_key) 
                VALUES (:user_email, :user_login, :user_password, :user_registered, :user_key)");
        $statement->execute(array(
            "user_email" => $get_email,
            "user_login" => $user_login,
            "user_password" => $get_password_hashed,
            "user_registered" => $date,
            "user_key" => $private_key,
        ));
        echo '1';
    }
}

?>