<?php

namespace App\Console\Commands;

use App\Models\Mqtt;
use App\Models\cdStatistic;
use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;

class MqttSubscriber extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $mqttClient = Mqtt::first();
        $client = new MqttClient($mqttClient->host, $mqttClient->port, "ClientID");
        $client->connect();
        $client->subscribe($mqttClient->topic, function ($topic, $message , $qos) use ($mqttClient) {
            $this->info("Received message on topic '$topic' from host $mqttClient->host:  $message" );

            $fixid_json = str_replace(
                [':', ', ', '{', '}'],
                ['":"', '", "', '{"', '"}'],
                $message
            );
            
            $parsedData = json_decode($fixid_json, true);

            cdStatistic::Create([
                "deviceid" => $parsedData['device_id'],
                "peoplecount" => $parsedData['people_total'],
                'time' => date('H:i:s', $parsedData['timestamp']),
                'date' => date('Y-m-d', $parsedData['timestamp']),
            ]);
        

        });

        $client->loop(true);
    }
}
