<?php

namespace App\Console\Commands;

use App\Models\Mqtt;
use App\Models\cdrtconfig;
use App\Models\cdStatistic;
use App\Models\ovcrowdalerts;
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
        $client->subscribe($mqttClient->topic, function ($topic, $message, $qos) use ($mqttClient) {
            $this->info("Received message on topic '$topic' from host $mqttClient->host:  $message");

            $fixid_json = str_replace(
                [':', ', ', '{', '}'],
                ['":"', '", "', '{"', '"}'],
                $message
            );

            $parsedData = json_decode($fixid_json, true);

            $timestamp = $parsedData['timestamp']; 

            $hours = date('H', $timestamp);
            $minutes = date('i', $timestamp);
            $seconds = date('s', $timestamp);

            cdStatistic::Create([
                "deviceid" => trim($parsedData['device_id']),
                "peoplecount" => trim($parsedData['people_total']),
                'people_with_mask' => trim($parsedData['people_with_mask']), 
                'people_without_mask' => trim($parsedData['people_without_mask']),                
                'time' => date('H:i:s', $parsedData['timestamp']),
                'date' => date('Y-m-d', $parsedData['timestamp']),
                'hours' => $hours,
                'minutes' => $minutes, 
                'seconds' => $seconds, 
            ]);

            $cdrtConfig = Cdrtconfig::where('deviceid', trim($parsedData['device_id']))->first();
    
            $maxcrowd = $cdrtConfig->maxcrowd;

            if(trim($parsedData['people_total']) > $maxcrowd){
                ovcrowdalerts::Create([
                    "deviceid" => trim($parsedData['device_id']),
                    "peoplecount" => trim($parsedData['people_total']),            
                    'time' => date('H:i:s', $parsedData['timestamp']),
                    'date' => date('Y-m-d', $parsedData['timestamp']),
                    'hours' => $hours,
                    'minutes' => $minutes, 
                    'seconds' => $seconds, 
                    'seen' => 'false'
                ]);



            }
            $this->info("Received message on topic '$topic' from host $mqttClient->host:  $maxcrowd");
        });

        $client->loop(true);
    }
}
