<?php
require_once('db.php');
require_once('functions.php');

global $db;

date_default_timezone_set('Europe/Warsaw');
$current_date = date("Y-m-d H:i:s");
$minutes_to_add = 1;
$time = new DateTime($$current_date);
$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
$new = $stamp = $time->format('Y-m-d H:i:s');
$data = $db->prepare('DELETE FROM queue WHERE q_time < :time');
$data->bindValue(':time', $new, PDO::PARAM_STR);
$data->execute();

$create_matches = $db->prepare('SELECT FROM queue WHERE q_time > :time');
$create_matches->bindValue(':time', $new, PDO::PARAM_STR);
$create_matches->execute();
$count = $create_matches->rowCount();

if($count > 2)
while ($row = $create_matches->fetch()) {
    $q_id = $row['q_id'];
    $q_user_id = $row['q_user_id'];
    $q_time = $row['q_time'];



}


?>