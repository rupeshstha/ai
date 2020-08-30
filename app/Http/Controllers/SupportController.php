<?php

namespace App\Http\Controllers;

//require __DIR__.'/dialogflow/vendor/autoload.php';
require '../vendor/autoload.php';

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Intent;
use Google\Cloud\Dialogflow\V2\IntentView;
use Google\Cloud\Dialogflow\V2\IntentsClient;
use Google\Cloud\Dialogflow\V2\Intent_Message;
use Google\Cloud\Dialogflow\V2\Intent_Message_Text;
use Google\Cloud\Dialogflow\V2\Intent_TrainingPhrase;
use Google\Cloud\Dialogflow\V2\Intent_TrainingPhrase_Part;
use Google\Cloud\Dialogflow\V2\AgentsClient;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Storage\StorageClient;



class SupportController extends Controller
{
    public function __construct()
    {
        $filePath = asset('dialogflow/'.env('GOOGLE_FILE_NAME').'.json');
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$filePath);
    }

    public function test(Request $request)
    {
//        dd(asset('dialogflow/'.env('GOOGLE_FILE_NAME').'.json'));
        // Authenticating with keyfile data.
        $storage = new SessionsClient([
            'keyFile' => json_decode(asset('dialogflow/'.env('GOOGLE_FILE_NAME').'.json'), true),
            'keyFilePath' => asset('dialogflow/'.env('GOOGLE_FILE_NAME').'.json'),
            'projectId' => 'girlfriend'
        ]);

        dd($storage);

        // Authenticating with a keyfile path.
        $sessionsClient = new SessionsClient();



        $post_request = new Client();
        // new session
//        $sessionsClient = new SessionsClient();
//        $session = $sessionsClient->sessionName($projectId, $sessionId ?: uniqid());
//        dd('$session');
        $seed = "abcdef1234567890";
        $first = substr( str_shuffle($seed), 0, 8);
        $second  = substr( str_shuffle($seed), 0 , 4);
        $third = substr( str_shuffle($seed), 0 , 4);
        $forth = substr( str_shuffle($seed), 0 , 4);
        $session_id = substr(str_shuffle($seed),0, 12);

        $post_url = "https://dialogflow.clients6.google.com/v2/projects/girlfriend-xkcv/agent/sessions/{$first}-{$second}-9b23-c0e4-{$session_id}:detectIntent";
//        dd($post_url);

        $headers = [
            "Content-Type" => "application/json; charset=utf-8",
            "Authorization" => "Bearer ya29.c.Ko8B2gdGRwxYHpLrEKEoHPlNEnik3CKmyBiHrKBDwWaNTlGIQQLCywSnMclIXaJ0qKdQZ_rkXMpcgLt_Sn2z0ArhUj6fV7-3H4HPfDQg1pvfqhUYtMQdHNZ56X_S7NOoeHc9b966-NbgpC5H1dz0zfOwMUKdrXSzTjowmGyXLNyhqCQducFXJnd8PeJLqTkhwEE"
        ];

        $form_params = json_encode([
            "queryInput" => [
                "text"=> [
                    "text" => $request->message,
                    "languageCode"=> "en"
                ]
            ],
            "queryParams"=>[
                "timeZone"=>"Asia/Kathmandu"
            ]
        ]);

        $send_request = $post_request->request('POST', $post_url,[
            "headers" => $headers,
            "body" => $form_params
        ]);

//        dd(json_decode($send_request->getBody()));
        $intent = json_decode($send_request->getBody())->queryResult->fulfillmentText;
        $reply = $intent;
//            ->queryResult->intent->displayName;
//        $reply = Intent::where('name', $intent)->first()->reply ?? 'Sorry!';
//        switch ($intent) {
//            case('tech-support'):
//                $reply = "Hi, a representative will solve your issue.";
//                break;
//            default:
//                $reply = "I'm quite not sure what you ment :( but thanks will be learning from this :)";
//                break;
//        }
        return view('index', compact('reply'));
    }

    public function intent()
    {
        $intentsClient = new IntentsClient();
        $parent = $intentsClient->projectAgentName('girlfriend');

        $intents = $intentsClient->listIntents($parent,array(“intentView”=>1));
        $allIntents = array();
        $iterator = $intents->getPage()->getResponseObject()->getIntents()->getIterator();
        while($iterator->valid()){
        $intent = $iterator->current();
        $allIntents[] = array(“id”=>$intent->getName(),”name”=>$intent->getDisplayName());
        $iterator->next();
        }
        return Response::json(array(‘success’=>true,”allIntents”=>$allIntents));
    }








}
