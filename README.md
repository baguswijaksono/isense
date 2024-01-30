## Installation

### Local
Run the following command to clone the repository, and install the dependencies:

```sh
git clone https://github.com/baguswijaksono/isense.git
cd isense
composer install
```

start the migration with the following command:

```sh
php artisan migrate
```

start the server with the following command:

```sh
php artisan serve
```
> Now the server is running on http://localhost:8000

for running the MQTT subscriber, 
```sh
php artisan mqtt:subscribe
```

> you'll typically need to open two separate terminal windows or tabs to run these commands in parallel. Each command runs a long-lived process, and they are not typically run together in the same terminal.


### livestream config 

change this line

```sh
STREAM_URL="rtsp://192.168.1.30:1935/" 
```

on public\live\stream_script.sh then run the shell script

start also stream limit on public/live/stream_limiter.sh