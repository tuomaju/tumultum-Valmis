<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 27.11.2017
 * Time: 13.20
 */
session_start();

/**
 * @param $profileId
 * @param $DBH
 * @return mixed
 * Palauttaa profiilin tiedot
 */
function getProfile($profileId, $DBH){   //profileid/userid???? mikä vitun juttu
    try {
        $userdata = array('profileId' => $profileId);
        $STH = $DBH->prepare("SELECT * FROM p_profile WHERE profileId= '$profileId'");
        $STH->execute($userdata);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $row = $STH->fetch();
        return $row;
    } catch(PDOException $e) {
        echo "Profile get error";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}

/**
 * @param $postId
 * @param $DBH
 * Poistaa postauksen ja sen kommentit ja scoren
 */
function removePost($postId, $DBH){
    try {
        $STH = $DBH->prepare("
          DELETE FROM 
            p_comment
          WHERE 
            commentPost = $postId;
          DELETE FROM 
            p_score
          WHERE 
            postId = $postId;
          DELETE FROM 
            p_post
          WHERE 
            postId = $postId ;
          
        ");
        $STH->execute();
    } catch(PDOException $e) {
        echo "Remove error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}

/**
 * @param $commentId
 * @param $DBH
 * Poistaa kommentin
 */
function removeComment($commentId, $DBH){
    try {
        $STH = $DBH->prepare("
          DELETE FROM 
            p_comment
          WHERE 
            commentId = $commentId; 
        ");
        $STH->execute();
    } catch(PDOException $e) {
        echo "Remove comment error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}


/**
 * @param $userId
 * @param $DBH
 * Tarkistaa, onko käyttäjä admin
 */
function checkAdmin($userId, $DBH){
    $STH = $DBH->prepare("
    SELECT admin
    FROM p_user
    WHERE userId = $userId;
    ");
    $STH->execute();
    $row = $STH->fetch();
    return $row;
}

/**
 * @param $postId
 * @param $userId
 * @param $DBH
 * tekee poistonapin jos käyttäjä on admin
 */
function removeButton($postId, $userId, $DBH){
    try{
        if (checkAdmin($userId, $DBH)[0]==1){
            echo '<button class="adminBtn"><a href="removePost.php?postId='.$postId.'">🚮REMOVE🚮POST🚮</a></button>';
        }
    }catch(PDOException $e) {
        echo "Remove error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}

/**
 * @param $userId
 * @param $commentId
 * @param $DBH
 * tekee poistonapin jos käyttäjä admin
 */
function removeCommentButton($userId, $commentId, $DBH){
    try{
        if (checkAdmin($userId, $DBH)[0]==1){
            echo '<button class="adminBtn"><a href="removeComment.php?commentId='.$commentId.'">🚮REMOVE🚮COMMENT🚮</a></button>';
        }
    }catch(PDOException $e) {
        echo "Remove comment error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}

/**
 * @param $profileId
 * @param $column
 * @param $value
 * @param $DBH
 * Vaihtaa profiiliin arvon value sarakkeeseen column
 */
function editProfile($profileId, $column, $value,  $DBH){  //profileid/userid???? mikä vitun juttu :DDDDDDDDDDddddddddddDDDDDDDDDD
    try {
        $STH4 = $DBH->prepare("UPDATE p_profile SET $column = '$value' WHERE profileUser = '$profileId'");
        $STH4->execute();
    } catch(PDOException $e) {
        echo "Profile edit error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}


/**
 * @param $postId
 * @param $DBH
 * @return mixed
 * hakee postista kaiken
 */
function getPost($postId, $emoji, $DBH){
    try {
        $userdata = array('postId' => $postId);
        $STH = $DBH->prepare("SELECT * FROM p_post WHERE postId = $postId AND (emoji1 $emoji OR emoji2  $emoji OR emoji3  $emoji OR emoji4 $emoji)"); //
        $STH->execute($userdata);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $row = $STH->fetch();
        return $row;
    } catch(PDOException $e) {
        echo "Post get error";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}



/**
 * @param $emoji
 * @return mixed
 * +1 backslash
 */
function encodeEmoji($emoji){
    $placeholder= json_encode($emoji);
    $strReplace = str_replace('\\','\\\\',$placeholder);
    return $strReplace;
}

/**
 * @param $emoji
 * @return mixed
 * +1 backslash ja hipsun eteen backslash
 */
function encodeEmoji2($emoji){
    $placeholder= json_encode($emoji);
    $placeholder2 = str_replace('\\','\\\\',$placeholder);
    $strReplace = str_replace('"','\\"',$placeholder2);
    return $strReplace;
}

/**
 * @param $postId
 * @param $emoji
 * @param $DBH
 * @return mixed
 * hakee ja palauttaa emojin
 */
function decodeEmoji($postId, $emoji, $DBH){
    $muuttuva = getPost($postId,'IS NOT NULL', $DBH)->$emoji;
    return json_decode(''.$muuttuva.'');
}




/**
 * @param $audio
 * @param $emoji1
 * @param $emoji2
 * @param $emoji3
 * @param $emoji4
 * @param $profileId
 * @param $DBH
 * insertaa postiin arvot
 */
function makePost($audio, $emoji1, $emoji2, $emoji3, $emoji4, $profileId, $DBH){
    try {
        $newEmoji1 = encodeEmoji($emoji1);
        $newEmoji2 = encodeEmoji($emoji2);
        $newEmoji3 = encodeEmoji($emoji3);
        $newEmoji4 = encodeEmoji($emoji4);

        $STH = $DBH->prepare("INSERT INTO p_post(
            audio,
            emoji1,
            emoji2,
            emoji3,
            emoji4,
            postProfile,        
            postTime
        )
        VALUES(
            '$audio',
            '$newEmoji1',
            '$newEmoji2',
            '$newEmoji3',
            '$newEmoji4',
            $profileId,
            CURRENT_TIMESTAMP 
        );    
        ");
        $STH->execute();

    } catch(PDOException $e) {
        echo "Make post error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}

/**
 * @param $DBH
 * @return mixed
 * palauttaa isoimman id:n
 */
function getMaxId($id, $table, $DBH){
    $STH = $DBH->prepare("SELECT MAX($id) FROM $table");
    $STH->execute();
    $row = $STH->fetch();
    return $row;
}


/**
 * @param $postId
 * @param $DBH
 * @return mixed
 * Hakee ja summaa postin scoren
 */
function getPostScore ($postId, $DBH){
    $STH = $DBH->prepare("SELECT SUM(score) FROM p_score WHERE postId = $postId");
    $STH->execute();
    $row = $STH->fetch();
    if(!$row[0]){
        $row[0] = '0';
        return $row;
    }
    return $row;

}

/**
 * @param $profileId
 * @param $DBH
 * @return mixed
 * Hakee ja summaa profilen scoren
 */
function getProfileScore($profileId, $DBH){
    $STH = $DBH->prepare("SELECT 
	  SUM(s.score)
    FROM
        p_score AS s,
        p_post AS p
    WHERE
        p.postProfile = $profileId
        AND
        p.postId = s.postId");
    $STH->execute();
    $row = $STH->fetch();
    if(!$row[0]){
        $row[0] = '0';
        return $row;
    }
    return $row;
}


/**
 * @param $luku
 * @param $DBH
 * Näyttää 20 uusinta postaukset
 */
function showPosts($luku, $search, $DBH){

    if(!$search) {
        $search = 'IS NOT NULL';
    } else {
        $search= '= "' . encodeEmoji2($search) .'"';
    }

    for ($j = $luku; $j >= $luku - 20; $j--) {       //joku bittijuttu et tulee negatiiviset yli ??  VOIS kans järjestää post timella
        if (getPost($j, $search, $DBH)) {
            $asd = getPost($j, $search, $DBH)->postProfile;
            echo '<div class="postsBox">';
            echo '<p class="dateBreak"></p>';
                echo '<li class="posts oranssi" id="'.$j.'">';
                    echo '<div class="postHeader">';
                        echo '<div class="profileImgBox">';
                            echo '<img class="profileimg" src="' . getProfile($asd, $DBH)->img . '">';
                            echo '<a href="showProfile.php?profileId='.getProfile($asd, $DBH)->profileId.'">'. getProfile($asd, $DBH)->profileName.'</a>';
                        echo '</div>';

                        $date = explode(' ' , getPost($j, $search, $DBH)->postTime, 2)[0];
                        $time = explode(' ' , getPost($j, $search, $DBH)->postTime, 2)[1];
                        $h = explode(':', $time)[0];
                        $min = explode(':', $time)[1];
                        echo '<p class="postDate">'. $date .'</p>';
                        echo '<p class="postTime">' .  $h . ':' . $min . '</p>';
                    echo '</div>';
                    echo '<div class="postMain">';
                        echo '<div class="playbtnBox">';
                            echo '<audio controls><source src="' . getPost($j, $search, $DBH)->audio . '"></audio>';
                            echo '<img class="playbtn" src="icons/play.svg">';
                            echo '<img class="pausebtn" src="icons/pause3.svg">';
                            echo '<p class="counter"></p>';
                        echo '</div>';
                        echo '<div class="emojiContainer">';
                            echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji1', $DBH) . '</p>';
                            echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji2', $DBH) . '</p>';
                            echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji3', $DBH) . '</p>';
                            echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji4', $DBH) . '</p>';
                        echo '</div>';

                        echo '<div class="postLike">';
                            echo '<a href="like.php?postId='.$j.'"><img src="icons/upvote.svg"></a>';
                            echo '<p class="score">' . getPostScore($j, $DBH)[0] . '</p>';
                            echo '<a href="dislike.php?postId='.$j.'"><img src="icons/downvote.svg"></a>';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="fullPostModal modalHidden">';
                        include 'fullPost.php';
                    echo '</div>';
                    echo '<div class="postFooter">';
                        echo '<h3>•</h3>';
                        echo '<h2>•</h2>';
                        echo '<h3>•</h3>';
                    echo '</div>';
                    removeButton($j,$_SESSION['userId'], $DBH);
                echo '</li>';
            echo '</div>';

        }
    }
}

/**
 * @param $profileId
 * @param $DBH
 * näyttää profiilin kaikki postit
 */
function showProfilePosts($profileId, $DBH){

    $search = 'IS NOT NULL';
    $luku = getMaxId('postId', 'p_post', $DBH)[0];

    for ($j = $luku ; $j >= 0; $j--) {       //joku bittijuttu et tulee negatiiviset yli ??  VOIS kans järjestää post timella
        if (getPost($j, $search, $DBH)->postProfile == $profileId) {
            if (getPost($j, $search, $DBH)) {
                $asd = getPost($j, $search, $DBH)->postProfile;
                echo '<div class="postsBox">';
                    echo '<p class="dateBreak"></p>';
                    echo '<li class="posts oranssi" id="'.$j.'">';
                        echo '<div class="postHeader">';
                            echo '<div class="profileImgBox">';
                            echo '<img class="profileimg" src="' . getProfile($asd, $DBH)->img . '">';
                            echo '<a href="showProfile.php?profileId='.getProfile($asd, $DBH)->profileId.'">'. getProfile($asd, $DBH)->profileName.'</a>';
                            echo '</div>';

                                $date = explode(' ' , getPost($j, $search, $DBH)->postTime, 2)[0];
                                $time = explode(' ' , getPost($j, $search, $DBH)->postTime, 2)[1];
                                $h = explode(':', $time)[0];
                                $min = explode(':', $time)[1];
                                echo '<p class="postDate">'. $date .'</p>';
                                echo '<p class="postTime">' .  $h . ':' . $min . '</p>';
                                echo '</div>';
                                    echo '<div class="postMain">';
                                    echo '<div class="playbtnBox">';
                                    echo '<audio controls><source src="' . getPost($j, $search, $DBH)->audio . '"></audio>';
                                    echo '<img class="playbtn" src="icons/play.svg">';
                                    echo '<img class="pausebtn" src="icons/pause3.svg">';
                                    echo '<p class="counter"></p>';
                                echo '</div>';
                                echo '<div class="emojiContainer">';
                                    echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji1', $DBH) . '</p>';
                                    echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji2', $DBH) . '</p>';
                                    echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji3', $DBH) . '</p>';
                                    echo '<p class="emoji vaalea">' . decodeEmoji($j, 'emoji4', $DBH) . '</p>';
                                echo '</div>';

                                echo '<div class="postLike">';
                                    echo '<a href="like.php?postId='.$j.'"><img src="icons/upvote.svg"></a>';
                                    echo '<p class="score">' . getPostScore($j, $DBH)[0] . '</p>';
                                    echo '<a href="dislike.php?postId='.$j.'"><img src="icons/downvote.svg"></a>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="fullPostModal modalHidden">';
                                include 'fullPost.php';
                            echo '</div>';
                            echo '<div class="postFooter">';
                            echo '<h3>•</h3>';
                            echo '<h2>•</h2>';
                            echo '<h3>•</h3>';
                        echo '</div>';
                        removeButton($j,$_SESSION['userId'], $DBH);
                    echo '</li>';
                echo '</div>';
            }
        }
    }
}


/**
 * @param $postId
 * @param $DBH
 * näyttää koko jutun
 */
function showPostsFull($postId, $DBH){
    echo '<li class="posts">';
    echo '<audio controls> <source src="'. getPost($postId,'IS NOT NULL', $DBH)->audio .'"></audio>';
    echo '<br>';
    echo '<div class="emojiContainer">';
    echo '<p class="emoji vaalea">' . decodeEmoji($postId, 'emoji1', $DBH) . '</p>';
    echo '<p class="emoji vaalea">' . decodeEmoji($postId, 'emoji2', $DBH) . '</p>';
    echo '<p class="emoji vaalea">' . decodeEmoji($postId, 'emoji3', $DBH) . '</p>';
    echo '<p class="emoji vaalea">' . decodeEmoji($postId, 'emoji4', $DBH) . '</p>';
    echo '</div>';
    $profileId = getPost($postId,'IS NOT NULL', $DBH)->postProfile;
    echo '<br>';
    echo 'post score: ' . getPost($postId,'IS NOT NULL', $DBH)->score;
    echo '<br>';
    echo 'post time: ' . getPost($postId,'IS NOT NULL', $DBH)->postTime;
    echo '<br>';
    echo '<img class="profileimg" src="'. getProfile($profileId, $DBH)->img .'">';
    echo '<br>';
    echo 'Profile name: ' . getProfile($profileId, $DBH)->profileName;
    removeButton($postId, $_SESSION['userId'], $DBH);
    echo '</li>';
}

/**
 * @param $comment
 * @param $profileId
 * @param $postId
 * @param $DBH
 * lisää kommentin
 */
function insertComment($comment, $profileId, $postId, $DBH){
    try {
        $STH = $DBH->prepare("INSERT INTO p_comment(
          commentText,
          commentPost,
          commentProfile
        )VALUES(
          '$comment',
          '$postId',
          '$profileId'
        );
        ");
        $STH->execute();

    } catch(PDOException $e) {
        echo "Comment error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}


/**
 * @param $postId
 * @param $commentId
 * @param $DBH
 * @return mixed
 * hakee kommentin
 */
function getComment($postId, $commentId, $DBH){
    try {
        $userdata = array('postId' => $postId);

        $STH = $DBH->prepare("SELECT * FROM p_comment WHERE commentPost = $postId AND commentId = $commentId");
        $STH->execute($userdata);
        $row = $STH->fetch();
        return $row;
    } catch(PDOException $e) {
        echo "Post get error";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }

}


/**
 * @param $postId
 * @param $DBH
 * näyttää kommentit
 */
function showComments($postId, $DBH){
    $luku = getMaxId('commentId' , 'p_comment' , $DBH)[0];
    for ($i = 1; $i <= $luku; $i++) {       //joku bittijuttu et tulee negatiiviset yli ??  VOIS kans järjestää post timella
        if (getComment($postId, $i, $DBH)) {
            echo '<br>';
            echo '<li class="comment vaalea">';
            echo '<div class="commentHeader">';
            echo '<img src=" '. getProfile(getComment($postId, $i, $DBH)[3], $DBH)->img . '">';
            echo '<a href="showProfile.php?profileId='.getProfile(getComment($postId, $i, $DBH)[3], $DBH)->profileId.'">'.getProfile(getComment($postId, $i, $DBH)[3], $DBH)->profileName. '</a> ';
            echo getProfile(getComment($postId, $i, $DBH)[3], $DBH)->score;
            echo '</div>';
            echo '<p>' . getComment($postId, $i, $DBH)[1] . '</p>';
            removeCommentButton($_SESSION['userId'], $i, $DBH);
            echo '</li>';


        }
    }
}

/**
 * @param $postId
 * @param $profileId
 * @param $DBH
 * @return mixed
 * Tarkistaa onko profiililla jo tykätty
 */
function hasLiked($postId, $profileId, $DBH){

    $STH = $DBH->prepare("SELECT * FROM p_score WHERE postId = $postId AND profileId = $profileId");
    $STH->execute();
    $row = $STH->fetch();
    return $row;
};

/**
 * @param $postId
 * @param $profileId
 * @param $like
 * @param $DBH
 * Lisää tykkäyksen
 */
function addLike($postId, $profileId, $like, $DBH){
    try {
        if(!hasLiked($postId, $profileId, $DBH)){

            $STH = $DBH->prepare("INSERT INTO p_score(
              postId,
              profileId,
              score
            )VALUES(
              '$postId',
              '$profileId',
              $like
            );
            ");
            $STH->execute();
        } else {
            $STH = $DBH->prepare("UPDATE p_score
            SET score = $like 
            WHERE postId = $postId
            AND profileId = $profileId;
            ");
            $STH->execute();
        }
    } catch(PDOException $e) {
        echo "Like error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}

/**
 * @param $profileId
 * @param $DBH
 * @return mixed
 * Näyttää profiilin kaikki postit
 */
function getProfilePosts($profileId, $DBH){
    try {
        $STH = $DBH->prepare("SELECT * FROM p_post WHERE postProfile = $profileId ");
        $STH->execute();
       $STH->setFetchMode(PDO::FETCH_OBJ);
        $row = $STH->fetch();
        return $row;
    } catch(PDOException $e) {
        echo "Post get error";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}


?>


