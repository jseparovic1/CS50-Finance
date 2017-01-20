<?php

   /**
     * quote.php
     *
     * gets quote
     *
     */
     
    require("../includes/config.php");
    if(!empty($_POST["symbol"]))
    {
         $userSearch = htmlspecialchars($_POST["symbol"]);
         $stock = lookup($userSearch);
         if(!empty($stock))
         {
             // render stock view
             $stock["price"] = number_format($stock["price"], 2, '.', ',');
             render("quote.php",$stock);
         }
         else
         {
             apologize("Symbol not found !");
         }
    }
    render("quote_form.php",["title" => "Quote"]);

?>