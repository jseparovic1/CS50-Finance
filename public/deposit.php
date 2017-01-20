<?php
    
    require("../includes/config.php");
    if(isset($_POST["add"]))
    {
        //check user input
        $funds = $_POST["amount"];
        if (preg_match("/^\d+$/", $funds))
        {
            CS50::query("UPDATE users SET cash=cash+? WHERE id =?",$funds,$_SESSION["id"]);
            redirect("/");
        }
    }
    else
    {
        render("deposit_form.php",["title" => "Add funds"]);
    }
?>