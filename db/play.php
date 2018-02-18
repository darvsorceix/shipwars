<?php
require_once('db.php');
require_once('functions.php');

global $db;

$postData = file_get_contents("php://input");
$request = json_decode($postData);
$play = $request->player;
$hit = $request->hit;

if (!empty($play) and empty($hit)) {

    $result = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != "" AND m_p_a_accept = 1 AND m_p_b_accept = 1');
    $result->bindValue(':user_key', $play, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();

    $get = $result->fetch();
    $match_id = $get['m_id'];
    $player_a = $get['m_player_a'];
    $player_b = $get['m_player_b'];

    if ($player_a == $play) {
        $turn = 1;
    } else {
        $turn = 0;
    }

    $array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25);
    $random_keys = array_rand($array, 4);

    $a = $array[$random_keys[0]];
    $b = $array[$random_keys[1]];
    $c = $array[$random_keys[2]];
    $d = $array[$random_keys[3]];

    $md_player_a_fields = $a;
    $md_player_b_fields = $d;


    if ($check == 1) {

        $result2 = $db->prepare('SELECT * FROM matches_details WHERE md_match = :md_match');
        $result2->bindValue(':md_match', $match_id, PDO::PARAM_INT);

        $result2->execute();
        $check2 = $result2->rowCount();

        if ($check2 == 0) {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $db->prepare("INSERT INTO matches_details (md_match, md_player_a_fields, md_player_b_fields, md_turn)
                VALUES (:md_match, :md_player_a_fields, :md_player_b_fields, :md_turn)");
            $statement->execute(array(
                "md_match" => $match_id,
                "md_player_a_fields" => $md_player_a_fields,
                "md_player_b_fields" => $md_player_b_fields,
                "md_turn" => $play
            ));
            echo json_encode(array('ok' => 0, 'turn' => '1'));
        } else {
            $result2 = $db->prepare('SELECT * FROM matches_details WHERE md_match = :md_match AND md_turn = :md_turn');
            $result2->bindValue(':md_turn', $play, PDO::PARAM_STR);
            $result2->bindValue(':md_match', $match_id, PDO::PARAM_INT);

            $result2->execute();
            $check2 = $result2->rowCount();

            if ($check2 == 1) {
                echo json_encode(array('ok' => 1, 'turn' => 1));
            } else {
                echo json_encode(array('ok' => 1, 'turn' => 0));
            }
        }
    }
    else {
        echo json_encode(array('ok' => 1, 'turn' => 3));
    }
}

if (!empty($play) and !empty($hit)) {

    $result = $db->prepare('SELECT * FROM matches WHERE (m_player_a = :user_key OR m_player_b = :user_key) AND m_winner = "" AND m_player_a != "" AND m_player_b != "" AND m_p_a_accept = 1 AND m_p_b_accept = 1');
    $result->bindValue(':user_key', $play, PDO::PARAM_STR);
    $result->execute();
    $check = $result->rowCount();

    $get = $result->fetch();
    $match_id = $get['m_id'];
    $player_a = $get['m_player_a'];
    $player_b = $get['m_player_b'];

    $result2 = $db->prepare('SELECT * FROM matches_details WHERE md_match = :md_match AND md_turn = :md_turn');
    $result2->bindValue(':md_turn', $play, PDO::PARAM_STR);
    $result2->bindValue(':md_match', $match_id, PDO::PARAM_INT);

    $result2->execute();
    $check2 = $result2->rowCount();

    if ($check2 == 1) {
        if ($player_a == $play) {

            $get = $result2->fetch();
            $player_b_field = $get['md_player_b_fields'];

            if ($hit == $player_b_field) {
                echo json_encode(array('hit' => 1));
                $result2 = $db->prepare('UPDATE matches_details SET md_turn = "1" AND md_player_a_points = "1" WHERE md_match = :md_id');
                $result2->bindValue(':md_id', $match_id, PDO::PARAM_INT);
                $result2->execute();

                $result2 = $db->prepare('UPDATE matches SET m_winner = :winner WHERE m_id = :m_id');
                $result2->bindValue(':m_id', $match_id, PDO::PARAM_INT);
                $result2->bindValue(':winner', $play, PDO::PARAM_STR);
                $result2->execute();
            } else {
                $result2 = $db->prepare('UPDATE matches_details SET md_turn = :user_key WHERE md_match = :md_id');
                $result2->bindValue(':md_id', $match_id, PDO::PARAM_INT);
                $result2->bindValue(':user_key', $player_b, PDO::PARAM_STR);
                $result2->execute();
                echo json_encode(array('hit' => 0));
            }
        } elseif ($player_b = $play) {
            $get = $result2->fetch();
            $player_a_field = $get['md_player_a_fields'];

            if ($hit == $player_a_field) {
                echo json_encode(array('hit' => 1));
                $result2 = $db->prepare('UPDATE matches_details SET md_turn = "1" AND md_player_b_points = "1" WHERE md_match = :md_id');
                $result2->bindValue(':md_id', $match_id, PDO::PARAM_INT);
                $result2->execute();

                $result2 = $db->prepare('UPDATE matches SET m_winner = :winner WHERE m_id = :m_id');
                $result2->bindValue(':m_id', $match_id, PDO::PARAM_INT);
                $result2->bindValue(':winner', $play, PDO::PARAM_STR);
                $result2->execute();
            } else {
                $result2 = $db->prepare('UPDATE matches_details SET md_turn = :user_key WHERE md_match = :md_id');
                $result2->bindValue(':user_key', $player_a, PDO::PARAM_STR);
                $result2->bindValue(':md_id', $match_id, PDO::PARAM_INT);
                $result2->execute();
                echo json_encode(array('hit' => 0));
            }
        }
    }
}
?>

