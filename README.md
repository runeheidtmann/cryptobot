# cryptobot
A bot for automating crypto-trading and/or backtesting strategies

This is a very basic bot with interchangeable trading-strategies.

Installation:
#1. Create database need with the cryptobot.sql file
#2. Get API keys from Bitfinex trading account.
#2a Insert keys into secret.php
#3. You need to program your own strategy.

How the bot works:

Use a cron-job to call the index.php at a time interval of your choosing. 
It will insert the tickerprices in your chosen time interval. These prices is used by the strategy-algo, to calculate what action to take.

When the data is updated, it calls the Bot.

The bot has a Strategy and the strategy calculates a recommendation for selling or buying.
