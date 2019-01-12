<?php
include('bot.php');


/**
 * This Index is updating latest prices and calling the Bot, when updating is done.
 * Have a cron-job call this file at a timeinterval-of your choosing.
 *
 * If you want to backtest trading-strategy, you must alter updateData() to take your historical data and place it in database.
 * 
 */

if(updateData()){
    
    updateBot();
}
else{
    echo "Updating data failed. Pricepoint left out.";
}


function updateData(){
    
    // Get price-data from Bitfinex
    $data = getData();

    // Insert the pricepoint in database for
    $handler = new dbHandler();
    $insertData = $handler->insertNewTickerPrice($data);
    $counter = 0;

    // It is very important for the algorithm, that the pricepoints for calculating are in order.
    // therefor we try to update 5 times, before giving up.
    if(!$insertData){
    while(!$insertData && $counter<5){
        sleep(5);
        $insertData = $handler->insertNewTickerPrice($data);
        $counter++;
        }
    }

    if($insert) 
        return true;
    else 
        return false;

}
function getData(){
    
    //This particular bot is trading Riple.
    
    include('secrets.php');
    $bfx = new Bitfinex($api_key,$api_secret,$api_version);
    
    // Ripple Symbol is used for retrieving priceinformation.
    $ticker_array = $bfx->get_ticker("xrpusd");
	$ticker_price = $ticker_array["last_price"]; //number_format($ticker_array["last_price"], 4, ',', '');
    $ticker_time = $ticker_array["timestamp"];
    
    return $array = ['ticker_price' => $ticker_price,
                     'ticker_time' => $ticker_time
                    ];
}


/**
 * Now the data is ready, and the trading bot is now ready to calculate what to do.
 * 
 * With very little effort, you could implement the Observer-pattern here. You could have multiple bots trading several different cryptocurrencies.
 */
function updateBot(){
    $bot = new bot();
    $bot->update();    
}

?>
