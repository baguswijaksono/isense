Running the MQTT Broker and Web Server

To run the web app You need to run 
```
php artisan serve
```
(for serving your Laravel application) and 
```
php artisan mqtt:subscribe
``` 
(for running the MQTT subscriber) simultaneously, 


> you'll typically need to open two separate terminal windows or tabs to run these commands in parallel. Each command runs a long-lived process, and they are not typically run together in the same terminal.

