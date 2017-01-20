<?php
    
    require("../includes/config.php");
    
    if(!isset($_POST["buy"]))
    {
        render("buy_form.php",["title" => "Buy"]);
    }
    else
    {
        //check if user typed something for symbol and shares
        if(empty($_POST["symbol"]))
        {
            apologize("You must specify a stock to buy.");
        }
        if(empty($_POST["shares"]))
        {
            apologize("You must specify a number of shares.");
        }
        
        //check if number of shares is correct
        $shareNumber = $_POST["shares"];
        if(preg_match("/^\d+$/",$shareNumber))
        {
            //lookup for symbol and if correct buy shares
            $stock = lookup($_POST["symbol"]);
            if (!empty($stock)) 
            {
                //find user cash and check if he can afford selected stock
                $user = CS50::query("SELECT cash FROM users WHERE id =?",$_SESSION["id"]);
                if ($user[0]["cash"] > ($stock["price"] * $shareNumber)) 
                {
                    //update user cash
                    CS50::query("UPDATE users SET cash=cash-? WHERE id =?",($stock["price"]*$shareNumber),$_SESSION["id"]); 
                    
                    //enter new stock into database
                    CS50::query("INSERT INTO portfolios(shares,symbol,user_id) VALUES (?,?,?) ON DUPLICATE KEY UPDATE shares=shares+?",$shareNumber,$stock["symbol"],$_SESSION["id"],$shareNumber);
                    
                    //add transaction to history table
                    CS50::query("INSERT INTO history(shares,symbol,user_id,price,timestamp,transaction) VALUES (?,?,?,?,NOW(),'BUY')",$shareNumber,$stock["symbol"],$_SESSION["id"],$stock["price"]);
                    
                    //redirect to portfolios
                    redirect("/");
                }
                else
                {
                    apologize("You cant afford that , work harder");   
                }
            }
            else
            {
                 apologize("Symbol not found.");
            }
        }
        else
        {
            apologize("Invalid number of shares.");
        }
    }
?>