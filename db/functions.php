<?php
if(isset($_SESSION['user_id'])) {
    global $user_id;
    $user_id = $_SESSION['user_id'];
}
if(isset($_SESSION['lang'])) {
    global $user_lang;
    $user_lang = $_SESSION['lang'];
}

function is_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return true;
    } else {
        return false;
    }
}

function sanitize_text($string)
{
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return $string;
}

function random_hash()
{
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(md5(time()), 1);
}
?>