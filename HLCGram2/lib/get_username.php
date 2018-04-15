<?php
// A simple function to get the username from an id. We use this a lot above.
function get_username($id) {
    $dbi = mysqli_connect("localhost","PIApp","","CommIT2018");
    if ($dbi) {
        $q = "SELECT username FROM HLC_MMGramUSERS WHERE id = ?";
        if ($stmt = $dbi->prepare($q)) {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->bind_result($rUsername);
            $stmt->fetch();
            return $rUsername;
            $stmt->close();
        }
    }
    mysqli_close($dbi);
}
?>