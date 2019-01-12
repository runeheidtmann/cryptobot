<?php
include('dbh.php');
include('glidingMeans.php');
include('dbHandler.php');
include('bitfinex.php');

class bot{

    /**
     * Automated cryptotrading with interchangeable trading-strategies, using external library for calling Bitfinex-API
     * 
     * This application uses a Strategypattern to implement flexible algotrading. This very basic bot, has only to modes. Buy whith every dollar available, and sell it all.
     * It acts upon advice given from the algorithm.
     * 
     * The Bot has an update-function, wich is called, when a new crypto-price is ticking in.
     *  
     */
    
    // A bot has a interchangeable trading strategy, implementing with the Strategy-pattern.
    private $strategy;
    
    // A bot has acces to BFX-object, that handels communication with the Bitfinex API.
    private $bfx;

    // A bot has a wallet-array, containing information from bitfinex wallets
    private $wallet_array;
    private $ticker_price;
    private $ticker_price_time;
    
    // A bot has a dbHandler, that holds the methods for populating datafields necesary for calculating price-action.
    private $dbHandler;
            //fields populated by the dbHandler.

            //Are we currently in a trade? Default: false.
            private $inTrade = false;

    

    function __construct(){

        //API-KEY and SECRET is retrieved
        include('secrets.php');        
        
        //Interchangeably tradingStrategy
        $this->strategy = new glidingMeans();
        //helper-object
        $this->dbHandler = new dbHandler();
        
        //Get balances on tradingacount at Bitfinex
        $this->bfx = new Bitfinex($api_key,$api_secret,$api_version);
        $this->wallet_array = $this->bfx->get_balances();
        
        //Get prices if bot needs to buy
        $ticker_array = $this->bfx->get_ticker("xrpusd");
        $this->ticker_price = $ticker_array["last_price"];
        $this->ticker_price_time = $ticker_array["timestamp"]; 
        
        //Set Intrade-variable
        $this->inTrade = $this->dbHandler->getTradeState();
       

    }
    public function update(){

        // This method is called when prices are updated.
        // It now decides wether to buy,sell or hold.

        //Bot asks the trading-algo for advice. It returns a boolean.
        $buyPermission = $this->getAdvice();
        
        //If advise is a buy, and currently not holding a position, then buy.
        if($buyPermission && !$this->inTrade ){

            $this->openTrade();
        }
        //Sell if in trade and advice is a sell...
        elseif(!$buyPermission && $this->inTrade){
            $this->closeTrade();
        }
        //Otherwise just hold.
        else{
            //Printing what is doing.
            echo 'Hold! Status on wallets: '.$this->wallet_array[7]["amount"].'ellerxrp: '.$this->wallet_array[8]["amount"];
        }

    }
 
    private function getAdvice(){

        //Strategies always return a boolean
        //Either it recommends a buy or a sell.
        //Look at the Strategy-interface, end the algorithm in glidingMeans.php
        return $this->strategy->giveAdvice();
    }

    private function openTrade(){
        //places a market order for the full amount available on trading acount
        $walletUSD = $this->wallet_array[7]["amount"];
        $amount = $walletUSD / $this->ticker_price * 0.997;
      
        $order = $this->bfx->new_order('XRPUSD', "$amount", "1", 'bitfinex', 'buy', 'exchange market', $is_hidden = FALSE, $is_postonly = FALSE, $ocoorder = FALSE, $buy_price_oco = NULL);
        print_r($order);

        //sets necesary settings in databases
        if($this->dbHandler->setTradeState(1)){
            echo 'Intrade TRUE';
        }
        else {
                echo 'Intrade update failed';
            }
        //Make new record of order_open: 1 os opening, 0 is closing
        if($this->dbHandler->tradeRecording(1,$this->ticker_price,$this->ticker_price_time)){
            echo 'New trade record opened';
        }
        else {
                echo 'trade recording failed';
            }
        
        
        
    }
        
    
    private function closeTrade(){
        //places a sell market order for the full amount available on trading acount.
        $walletXRP = $this->wallet_array[8]["amount"];
        $order = $this->bfx->new_order('XRPUSD', "$walletXRP", "1", 'bitfinex', 'sell', 'exchange market', $is_hidden = FALSE, $is_postonly = FALSE, $ocoorder = FALSE, $buy_price_oco = NULL);
        print_r($order);
       
        //sets necesary settings in databases
        if($this->dbHandler->setTradeState(0)){
                echo 'Intrade FALSE';
        }
        else {
            echo 'Intrade update failed';
        }

        //Make new record of order_open: 1 os opening, 0 is closing
            if($this->dbHandler->tradeRecording(0,$this->ticker_price,$this->ticker_price_time)){
                echo 'Updated trade record';
            }
        else {
                echo 'trade updating failed';
                }

    }
    
    public function getIntrade(){
        return $this->inTrade;
    }
    public function get_ticker($symbol){
        
        return $this->bfx->get_ticker($symbol);
    }




}