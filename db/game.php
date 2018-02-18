<?php
require_once('db.php');
require_once('functions.php');

global $db;

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$get_information = $request->information;
$get_key = $request->key;
$play = $request->play;
$game = $request->game;
$redirect = $request->redirect;
$date = date("Y-m-d H:i:s");

$stats = $request->stats;

if (!empty($get_information)) {

    $queue = $db->prepare('SELECT * FROM queue');
    $queue->execute();
    $count = $queue->rowCount();

    echo json_encode(array('queue_people' => $count));
} elseif (!empty($get_key)) {

    $q_time = date("Y-m-d H:i:s");

    $delete_foo = $db->prepare("DELETE FROM queue WHERE q_user_id = :key");
    $delete_foo->execute(array(
        "key" => $get_key
    ));

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $db->prepare("REPLACE INTO queue (q_user_id, q_time) 
    VALUES (:q_user_id, :q_time)");
    $statement->execute(array(
        "q_user_id" => $get_key,
        "q_time" => $q_time
    ));

    // check if player already exist in match
    $result2 = $db->prepare('SELECT * FROM matches WHERE (m_player_a != "" AND m_player_a = :user_key AND m_player_b = "" AND m_winner = "") 
    OR (m_player_b = :user_key AND m_player_a = "" AND m_winner = "") OR (m_player_a = :user_key AND m_player_b != "" AND m_winner = "") OR (m_player_b != "" AND m_player_b = :user_key AND m_winner = "")
    OR (m_player_a != "" AND m_player_a != :user_key AND m_player_b = "" AND m_winner = "") OR (m_player_b != "" AND m_player_b != :user_key AND m_player_a = "" AND m_winner = "")');
    $result2->bindValue('user_key', $get_key, PDO::PARAM_STR);
    $result2->execute();
    $check2 = $result2->rowCount();

    if ($check2 == 0) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $db->prepare("INSERT INTO matches (m_player_a, m_player_b, m_winner, m_time) VALUES (:m_player_a, :m_player_b, :m_winner, :m_time)");
        $statement->execute(array(
            "m_player_a" => $get_key,
            "m_player_b" => '',
            "m_winner" => '',
            "m_time" => $q_time
        ));
    } else {
        $get_records = $result2->fetch();
        $get_match_id = $get_records['m_id'];
        $get_match_a = $get_records['m_player_a'];
        $get_match_b = $get_records['m_player_b'];

        if (empty($get_match_a) and !empty($get_match_b) and $get_match_b != $get_key) {
            $result = $db->prepare('UPDATE matches SET m_player_a = :user_key WHERE m_id = :m_id');
            $result->bindValue(':user_key', $get_key, PDO::PARAM_STR);
            $result->bindValue(':m_id', $get_match_id, PDO::PARAM_INT);
            $result->execute();
        } elseif (empty($get_match_b) and !empty($get_match_a) and $get_match_a != $get_key) {
            $result = $db->prepare('UPDATE matches SET m_player_b = :user_key WHERE m_id = :m_id');
            $result->bindValue(':user_key', $get_key, PDO::PARAM_STR);
            $result->bindValue(':m_id', $get_match_id, PDO::PARAM_INT);
            $result->execute();
        }
    }

    $result3 = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != ""');
    $result3->bindValue(':user_key', $get_key, PDO::PARAM_STR);
    $result3->execute();
    $check3 = $result3->rowCount();

    if ($check3 == 1) {
        echo json_encode(array('result' => '3'));
    } else {

        $result3 = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != "" AND m_p_a_accept = 1 AND m_p_b_accept = 1');
        $result3->bindValue(':user_key', $get_key, PDO::PARAM_STR);
        $result3->execute();
        $check3 = $result3->rowCount();

        if ($check3 == 1) {
            echo json_encode(array('result' => '4')); // go to game
        } else {
            echo json_encode(array('result' => '1')); // acceptance needed
        }
    }
}
if (!empty($play)) {

    $result = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != "" AND m_p_a_accept = 1 AND m_p_b_accept = 1');
    $result->bindValue(':user_key', $play, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();

    if ($check == 1) {
        echo json_encode(array('result' => '4')); // go to game
    } else {
        $result2 = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != ""');
        $result2->bindValue(':user_key', $play, PDO::PARAM_STR);
        $result2->execute();
        $check = $result2->rowCount();

        if ($check != 0) {
            $api = $result2->fetch();
            $get_match_id = $api['m_id'];
            $m_player_a = $api['m_player_a'];
            $m_player_b = $api['m_player_b'];

            if ($m_player_a == $play) {
                $result = $db->prepare('UPDATE matches SET m_p_a_accept = 1 WHERE m_id = :m_id');
                $result->bindValue(':m_id', $get_match_id, PDO::PARAM_INT);
                $result->execute();
                echo json_encode(array('result' => '1'));
            } elseif ($m_player_b == $play) {
                $result = $db->prepare('UPDATE matches SET m_p_b_accept = 1 WHERE m_id = :m_id');
                $result->bindValue(':m_id', $get_match_id, PDO::PARAM_INT);
                $result->execute();
                echo json_encode(array('result' => '1'));
            }
        } else {
            echo json_encode(array('result' => '4'));
        }
    }
}
if (!empty($redirect)) {

    $result = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != "" AND m_p_a_accept = 1 AND m_p_b_accept = 1');
    $result->bindValue(':user_key', $redirect, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();
    if ($check == 1) {
        echo json_encode(array('result' => '4')); // go to game
    } else {
        echo json_encode(array('result' => '1'));
    }
}

if (!empty($game)) {
    $result = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != "" AND m_p_a_accept = 1 AND m_p_b_accept = 1');
    $result->bindValue(':user_key', $game, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();

    $get = $result->fetch();
    $match_id = $get['m_id'];
    $player_a = $get['m_player_a'];
    $player_b = $get['m_player_b'];


    if ($check == 1) {

        if ($player_a != $game) {
            $result = $db->prepare('SELECT * FROM users WHERE user_key = :user_key');
            $result->bindValue(':user_key', $player_a, PDO::PARAM_STR);
            $result->execute();
            $get = $result->fetch();
            $player_two_login = $get['user_login'];
        } else if ($player_b != $game) {
            $result = $db->prepare('SELECT * FROM users WHERE user_key = :user_key');
            $result->bindValue(':user_key', $player_b, PDO::PARAM_STR);
            $result->execute();
            $get = $result->fetch();
            $player_two_login = $get['user_login'];
        } else {
            $player_two_login = '';
        }
        echo json_encode(array('result' => 4, 'enemy' => $player_two_login));
    } else {
        echo json_encode(array('result' => 0));
    }
}

if (!empty($stats)) {
    $result = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner != ""');
    $result->bindValue(':user_key', $stats, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();

    $result = $db->prepare('SELECT * FROM matches WHERE m_winner = :user_key');
    $result->bindValue(':user_key', $stats, PDO::PARAM_STR);
    $result->execute();
    $check2 = $result->rowCount();

    echo json_encode(array('total' => $check, 'won' => $check2));
}
?>