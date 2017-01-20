<?php

    // configuration
    require("../includes/config.php"); 
    
    //get user total cash from database and format it
    $userCash = CS50::query("SELECT cash FROM users WHERE id=?",$_SESSION["id"]);
    $userCash[0]["cash"] = number_format($userCash[0]["cash"], 2, '.', ',');
    
    //find users stocks and shares
    $rows = CS50::query("SELECT symbol,shares FROM portfolios WHERE user_id = ?",$_SESSION["id"]);
    
    //create array that contains all information to display on main page
    $positions = [];
        foreach($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if($stock !== false)
            {
                $totalPrice = $row["shares"] * $stock["price"];
                $totalPrice = number_format($totalPrice, 2, '.', ',');
                $positions[] =
                [
                    "name"   => $stock["name"],  
                    "price"  => $stock["price"],  
                    "shares" => $row["shares"],  
                    "symbol" => $row["symbol"],
                    "total"  => $totalPrice
                ];
            }
        }
      render("portfolio.php", ["positions" => $positions, "title" => "Portfolio" , "cash" => $userCash[0]["cash"]]);
    
?>
    