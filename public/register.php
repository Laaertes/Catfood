<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if (empty($_POST["confirmation"]))
        {
            apologize("You must confirm your password.");
        }   
                
        // password and confirmation must be equal
        if ($_POST["password"] != $_POST["confirmation"]) 
        {
            apologize("Your passwords must match.");
        } 
        
        // query database for user with existing username
        $result = query("SELECT * FROM users WHERE username = ?", $_POST["username"]);
        if ($result)
        {
            apologize("That username already exists.");
        }        
        else
        {
            // we finally filled out the form right, add the user
            $check = query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"]));
            
            // just in case it went wrong
            if ($check === false)
            {
                apologize("Please try again");
            }
            
            // if everything went right
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $id;
            
            // redirect to portfolio
            redirect("/");
        }
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
