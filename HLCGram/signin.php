<?php
    //Establish connection: host, user, password, database
    $dbi = mysqli_connect("localhost","PIApp","","CommIT2018");
    //Test connection
    if ($dbi) {
        //Prepare query
        /* This is a simple command to add the info in the DB, same as for the petition */
        $query = "INSERT INTO HLC_MMGramUSERS (username,password) VALUES ('" . 
            $_POST['username'] . "','" . 
            $_POST['password'] . 
            "')";

        //Run query
        if (mysqli_query($dbi,$query)) {
            //this line redirects to the main page
            header("Location: index.php");
            
            /* You could instead choose to automatically login the user after a new sign in and load the list.
               To do this, you could replace the header() line above (line 17) with something like this:
               
               header("Location: list.php?current=" . $dbi->insert_id);

               Remember that current means the id of the login user. 
               In this case, it gets the id of the new user just inserted that's the $dbi->insert_id
               */
        }
        else {
            //Error if INSERT does not work
            echo "Insert Error: " . mysqli_connect_error();
        }
    }
    //Inform user if connection error
    else {
        echo "Connection Error: " . mysqli_connect_error();
    }
    //Close connection
    mysqli_close($dbi);
?>