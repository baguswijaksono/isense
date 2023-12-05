## Installation

### Local
Run the following command to clone the repository, and install the dependencies:

```sh
git https://github.com/baguswijaksono/isense.git
cd isense
composer install
```

start the server with the following command:

```
php artisan serve
```
> Now the server is running on http://localhost:8000

for running the MQTT subscriber, 
```
php artisan mqtt:subscribe
```

> you'll typically need to open two separate terminal windows or tabs to run these commands in parallel. Each command runs a long-lived process, and they are not typically run together in the same terminal.


#### Database Design

##### User Collection

```json
{
  "_id": "ObjectId",
  "role": "String",
  "name": "String",
  "email": "String",
  "email_verified_at": "Date",
  "password": "String",
  "remember_token": "String",
  "created_at": "Date",
  "updated_at": "Date"
}
```
##### RTSP Collection

```json
{
  "_id": "ObjectId",
  "name": "String",
  "raw_url": "String",
  "image": "String",
  "description": "String",
  "created_at": "Date",
  "updated_at": "Date"
}
```

##### MQQT Messages Collection
```json
{
  "_id": "ObjectId",
  "topic": "String",
  "message": "String",
  "created_at": "Date",
  "updated_at": "Date"
}
```

##### MQQT Subscriber Info Collection
```json
{
  "_id": "ObjectId",
  "host": "String",
  "topic": "String",
  "port": "Number",
  "created_at": "Date",
  "updated_at": "Date"
}
```

##### Crowd Detection Collection
```json
{
  "_id": "ObjectId",
  "deviceid": "String",
  "peoplecount": "Number",
  "date": "Date",
  "time": "String",
  "created_at": "Date",
  "updated_at": "Date"
}
```


