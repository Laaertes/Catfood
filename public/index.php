<?php

    // configuration
    require("../includes/config.php"); 

    // get information from portfolios DB
    $row = query("SELECT symbol, shares FROM portfolios WHERE id = ?", $_SESSION["id"]);
    // user's cash balance
    $c = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    $cash = $c['0']['cash'];
    $cash = number_format($cash, 2);

    if (empty($row))
    {
        apologize("You don't have any shares at the moment.");
    }
    else
    {
        $positions = [];
        foreach($row as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"],
                "total" => $stock["price"] * $row["shares"]
                ];
            }
        }
    }

    // render portfolio
    render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);

?>
