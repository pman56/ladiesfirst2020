# Ladies First
An apps that connects Girls, Women and good People to Post and Share Useful Informations, Organize Protests, Fight for Gender Equity and Justice in the Society.


About Ladies First Demo


Ladies First can be accessed from
https://hackathon20-fesedo.quickbase.com/db/bqyb6cxvm


You can signup and Login or used already created account by going to login Page directly.

You are good to go.




Just a Tip, remember that the Application was designed to have both Front-End and Back-End

Here the Front-end applications is coded with Quickbase Code-Pages which makes Jquery/Ajax call to server PHP Back-end via Quickbase 
Json/XML API Call.

Incase you want to see the Code that runs the Server Backend, its on github via submitted link

https://github.com/pman56/ladiesfirst2020




To configure the Backend part of the code, You can have Xampp Server Install and ensure that PHP is running.
Our Applications leverages QuickBase Json and XML API Calls to perform all data manipulations activities
as regards to Insert, Update, Delete and Select etc.

The php Files that houses the Quickbase Configurable credentials includes 

# 1.) quickbase_pass.php : 
This is the first script to be updated. Here you will enter your Quickbase username and password to get
auth_ticket which you will be used later in the files below.

# 2.) Quickbase_token.php:
Houses your quickbase access token, app_token, auth_ticket and so on.

# 3.) Quickbase_token1.php:
Houses your quickbase access token etc.

# 4.)Quikbase_table.php:
Houses all the table ID's used in the application.


# 5.)Signup_action.php:
This is just for informations. Here you dont need to edit this two line of code below unless you want to replace
 your own quickbase domain or possibly change the users table Id

$users_table_db='users table id goes here';

$url4="https://hackathon20-fesedo.quickbase.com/db/$users_table_db";


