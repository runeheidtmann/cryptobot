# cryptobot
A bot for automating crypto-trading and/or backtesting strategies

This is a very basic bot with interchangeable trading-strategies.

Installation:
#1. Database for storring pricedata. Look in the dbHandler to see wich ones you need to create.
#2. Bitfinex trading account.
#3. You need to program your own strategy.

How the bot works:

Use a cron-job to activate the index.php at a time interval of your choosing. 
It will create a table for storing the tickerprices in your chosen time interval.

When the data is update, it calls the Bot.

The bot has a Strategy and the strategy calculates a recommendation for selling or buying.
