<?php
    $dbi = mysqli_connect("localhost","PIApp","","CommIT2018");
    if ($dbi) {
        $results = mysqli_query($dbi,"SELECT id FROM HLC_MMGramUSERS WHERE 
            username = '" . $_POST['username'] . 
            "' AND password = '" . $_POST['password'] . 
            "'");

        if (mysqli_num_rows($results) == 1) { //This means we have one user that matches
            while($r = mysqli_fetch_assoc($results)) {
                $url = "Location: index.php?user=" . $r['id'];
            }
            header($url);
        }
        else {
            echo "Error: wrong password or too many users";
        }
    }
    else {
        echo "Connection Error: " . mysqli_connect_error();
    }
    mysqli_close($dbi);
?>
