# Monitoring-CLF

Hey ! Here we are, three french students who have done their first application using Admin LTE.
The application is only available in french for the moment but it will be translated.


####What is Monitoring-CLF ?

It's a free monitoring application.
You can add websites (over http or https) on whatever port you want. The application will get the link you gave its, search for a text, get the response time and the HTTP code. If one of the values isn't correct, the app send you a mail and a mobile message when it's offline and when it get back online.

Made with love by Flavien Chene (<http://flavienchene.fr/>), Clément Droillard and Lénaïc Grolleau (<https://www.lenaic.me>)

####Requirements
* Linux server
* Webserver supporting PHP, JS and HTML.
* MySql server
* Postfix or other php mail services
* Crontab access

###Install

To install Monitoring-CLF, please set your username, host and password in the **includes/class_connexion.php** file for the database.
Then, import the bdd.sql file into your database.
The default username is **admin** and the default password is **coucou**.
Finally, your webserver need to point to the **html** folder. Users musn't have an access to other directories.
Warning : You need a good server to run this application. The ping of many services can slow down your server.

####Cron :
To install Cron app service, please **add the following line to your crontab** :

    * * * * * cd /var/www/html/Monitoring-CLF/ping && php5 -f cron.php > logs.php 2>&1

Don't forget de replace the folder of the application for this Cron.

###To do list :
* Add the **Free api** sms service (the current SMS service doesn't work).
* Add a group managment.
* Translate this app in english.
* Add an easy install process
* Correct the service bug when you add an URL (double http or https)


##How to update ?
Replace all the files except the **includes/class_connexion.php** file.
