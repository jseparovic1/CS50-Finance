<?php
    
    require("../includes/config.php");
    
    $transactions = CS50::query("SELECT * FROM history WHERE user_id =?",$_SESSION["id"]);
    render("history_table.php",["title" => "history" , "transactions" => $transactions]);
   
?>