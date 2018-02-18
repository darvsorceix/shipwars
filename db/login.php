<?php
require_once('db.php');
require_once('functions.php');

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$get_email = $request->email;
$get_password = $request->password;
$user_key = $request->key;


if (!empty($get_email) and !empty($get_password)) {
    $user_email = sanitize_text($get_email);
    $user_password = $get_password;

    if (!empty($user_email) and !empty($user_password) and is_email($user_email)) {

        $result = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
        $result->bindValue(':user_email', $user_email, PDO::PARAM_STR);
        $result->execute();
        $record = $result->fetch();
        $hashed_password = $record['user_password'];
        $user_id = $record['user_id'];
        $user_key = $record['user_key'];
        $user_login = $record['user_login'];

        if (!password_verify($user_password, $hashed_password)) {
            echo '0';
        } else {
            echo json_encode(array('api' => $user_key, 'login' => $user_login));
        }
    } else {
        echo '0';
    }
} elseif (!empty($user_key)) {
    $result = $db->prepare('SELECT * FROM users WHERE user_key = :user_key');
    $result->bindValue(':user_key', $user_key, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();

    if ($check != 0) {
        $record = $result->fetch();
        $user_login = $record['user_login'];
        echo json_encode(array('api' => $user_key, 'login' => $user_login));
    } else {
        echo '0';
    }
} else {
    echo '0';
}
?>