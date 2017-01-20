<?php
    require("../includes/config.php");

    if(isset($_POST["sell"]))
    {
        //check if something is actualy selected to sell
        if(isset($_POST["symbol_form"]))
        {
            //find selected value
            $toSell = $_POST["symbol_form"];

             //lookup stock for price
            $stock = lookup($toSell);
            
            //find user shares
            $share = CS50::query("SELECT shares FROM portfolios WHERE user_id = ? AND symbol=?",$_SESSION["id"],$toSell);
            
            //calculate money earned from selling
            $moneyEarned = $stock["price"] * $share[0]["shares"];
            
            // delete stock from portfolios database
            CS50::query("DELETE FROM portfolios WHERE user_id =? AND symbol = ?",$_SESSION["id"],$toSell);
            
            //update user total cash in database
            $cashChanged = CS50::query("UPDATE users SET cash=cash+? WHERE id =?",$moneyEarned,$_SESSION["id"]);
            
            //update history table
            CS50::query("INSERT INTO history(shares,symbol,user_id,price,timestamp,transaction) VALUES (?,?,?,?,NOW(),'SELL')",$share[0]["shares"],$toSell,$_SESSION["id"],$stock["price"]);
            if($cashChanged)
            {
                 redirect("/");
            }
        }
        else
        {
            apologize("You must select a stock to sell.");
        }
    }
    else
    {
        //find all stock that user owns
        $userStock = CS50::query("SELECT symbol,shares FROM portfolios WHERE user_id = ?",$_SESSION["id"]);
        //check if user actualy owns any stock
        if(empty($userStock)) 
        {
            apologize("Nothing to sell!");
        }
        else
        {
            render("sell_form.php",["title" => "Sell" , "stocks" => $userStock]);
        }
    }
?>