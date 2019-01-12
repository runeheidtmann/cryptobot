<?php

class dbHandler{


    /**
     * All sorts of functions calling the database for specific data.
     * 
     * If you want to have the same functions, make sure to make databasetables, that fit them.
     */

    private $conn;
    
    public function __construct(){

        $db = new dbh();
        $this->conn = $db->connect();
         
    }


    public function getTradeState(){
        
        $sql = "SELECT permission FROM longPermTable";
        $result = $this->conn->query($sql);

        $state = $result->fetch_assoc();
        

        if($state['permission'] == 0)
            return false;
        else return true;

    }
    public function setTradeState($inTrade){
        $sql = "UPDATE longPermTable SET permission=$inTrade";
		
		if($this->conn->query($sql) === TRUE){
            return true;
        } 
        else {
        echo "Error: " . $sql . "<br>";
        return false;
   		}

    }

    public function insertNewTickerPrice($data){
       
        $ticker_time = $data['ticker_time'];
        $ticker_price = $data['ticker_price'];

		$sql = "INSERT INTO tickerPrices (id, timestamp, ticker_price)
        VALUES (NULL, $ticker_time, $ticker_price)";

		if($this->conn->query($sql) === TRUE){
		  return true;
        } 
        else {
        echo "Error: " . $sql . "<br>";}
        return false;
    }
    public function tradeRecording($action,$price,$time){

        if($action == 1){
            // 1=open new record
            $sql = "INSERT INTO  longTrades (id, time_buy, price_buy)
             VALUES (NULL, $time, $price)";

            if($this->conn->query($sql) === TRUE){
                return true;
            } 
            else {
                echo "Error: " . $sql . "<br>";
                return false;
            }
            
            
        }
        elseif($action == 0){
            $selectId = "SELECT * FROM longTrades ORDER BY id DESC Limit 1";
			$result = $this->conn->query($selectId);
			$whatr = $result->fetch_assoc();
		
			$whatId = "UPDATE longTrades SET time_sell=$time, price_Sell=$price WHERE id='".$whatr['id']."' ";
			if($this->conn->query($whatId)){
                return true;
            }
            else return false;
            
            
        }
        else return false;

    }
  

}
?>