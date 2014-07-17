<?php

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a stock symbol.");
        }
        
        // look up stock symbol
        $stock = lookup($_POST["symbol"]);
        
        // if invalid stock symbol
        if ($stock === false) 
        {
            apologize("You must provide a valid stock symbol");
        }
        else
        {
            // format price in advance
            $price = number_format($stock['price'], 3);
            
            // send information to be displayed
            render("quote_display.php", ["title" => "Display Quote", 'symbol' => $stock['symbol'], 'name' => $stock['name'], 'price' => $price]);
        }
    }
    else 
    {
        render("quote_form.php", ["title" => "Get Quote"]);
    }
?>
