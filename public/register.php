<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"])) 
        {
            apologize("Please enter your username !");
        }
        elseif (strlen($_POST["username"]) < 3)
        {
             apologize("Your username should be at least 3 characters long");
        }
        // check if username already exist
        $userameCount = CS50::query("SELECT * FROM users WHERE username = ?",$_POST["username"]);
        if(count($userameCount) > 0)
        {
             apologize("Your username is already in use!");
        }
        
        if (empty($_POST["password"])) 
        {
            apologize("Please enter your password!");
        }
        elseif (strlen($_POST["password"]) < 5)
        {
             apologize("Your password should be at least 5 characters long");
        }
        
        if (empty($_POST["confirmation"])) 
        {
            apologize("Please confirm password!");
        }
        
        if(!($_POST["password"] === $_POST["confirmation"]))
        {
             apologize("Confirmation password incorrect!");
        }
        
        //if everything is ok inset new user to database
        $passwordHash = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $username = $_POST["username"];
        
        $insert = CS50::query("INSERT IGNORE INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)",$username,$passwordHash);
        //chek if insertion is done correctly
        if ($insert === false) 
        {
            apologize("registration failed ! :(");    
        }
    
        $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
        $id = $rows[0]["id"];
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username;
        
        redirect("index.php");
    }

?>