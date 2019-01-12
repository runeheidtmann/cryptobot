<?php
include('strategy.php');

class glidingMeans implements strategy{

    /**
     * Make an algorithm, that calculates wether to buy og sell.
     * 
     * Rememeber to return a boolean in the giveAdvice() function.
     * 
     * This file is called glidingMeans.php to illustrate, that you could make an algorithm based on to or more gliding price-means. 
     * When a long gliding mean intersect with a short, its time to do something.
     *
     * You also could use Bolling-bands. There are many strategies, you just have to calculate them.
     * 
     * From here you have acces to the database. Connect to get the data needed.
     * 
     */
  
    public function giveAdvice(){
        
        

    }

    

}