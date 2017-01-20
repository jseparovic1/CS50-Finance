<form action="sell.php" method="post">
    <fieldset>
        <div class="form-group">
            <select class="form-control" name="symbol_form">
                <option disabled selected value="">Symbol</option>
                <?php 
                    foreach($stocks as $stock)
                    {
                        printf("<option value='" . $stock["symbol"] ."'>");
                        printf($stock["symbol"]);
                        printf("</option>");
                    }                
                ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" name="sell" type="submit">Sell</button>
        </div>
    </fieldset>
</form>