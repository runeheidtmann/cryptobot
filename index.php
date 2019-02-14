<?php
include('bot.php');

if(updateData()){
    echo 'Pricepoint inserted into database <br> ';
    updateBot();
}
else{
    echo "Problemer med Update Data, formentlig insertNewTickerPrice";
}


function updateData(){
    
    $data = getData();
    $handler = new dbHandler();
    $insert = $handler->insertNewTickerPrice($data);
    $counter = 0;

    if(!$insert){
    while(!$insert && $counter<5){
        sleep(5);
        $insert = $handler->insertNewTickerPrice($data);
        $counter++;
        }
    }

    if($insert) 
        return true;
    else{
        $handler->dublicateAndInsertLastKnowPrice();
        echo "Dublicate inserted";
        return false;
    }

        
}
function getData(){
    
    include('secrets.php');
    $bfx = new Bitfinex($api_key,$api_secret,$api_version);
    
    $ticker_array = $bfx->get_ticker("xrpusd");
	$ticker_price = $ticker_array["last_price"]; //number_format($ticker_array["last_price"], 4, ',', '');
    $ticker_time = $ticker_array["timestamp"];
    
    return $array = ['ticker_price' => $ticker_price,
                     'ticker_time' => $ticker_time
                    ];
}

function updateBot(){
    $bot = new bot();
    $bot->update();    
}

?>