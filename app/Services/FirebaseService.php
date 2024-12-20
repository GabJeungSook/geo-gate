<?php

namespace App\Services;


use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseService{

    protected $messaging;

    public function __construct(){

        $factory = (new Factory)->withServiceAccount(storage_path('geogate-e01f8-ef52a9b5cf2f.json'));
        $this->messaging = $factory->createMessaging();

    }

    // public function sendNotification($deviceToken, $title, $body = [], $data = []){
    //     $message= CloudMessage::withTarget('token', $deviceToken)->withNotification(['title'=> $title, 'body'=> $body])->withData($data);


    //     $this->messaging->send($message);


    // }

    public function sendNotification($deviceToken, $title, $body, $data = [])
{
    $message = CloudMessage::withTarget('token', $deviceToken)
        ->withNotification(Notification::create($title, $body))
        ->withData($data);

    $this->messaging->send($message);
}





}
