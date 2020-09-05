<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';

use App\Http\Controllers\Controller;
use App\UserCounter;
use Dialogflow\WebhookClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Storage\StorageClient;

class SupportController extends Controller
{
//    public function __construct()
//    {
//        $filePath = asset('dialogflow/'.env('GOOGLE_FILE_NAME').'.json');
//        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$filePath);
//    }

    public function test(Request $request)
    {
//        dd();

        $data = $request->validate(['message'=>'required'],['message.required'=>"Oops! you didn't send me any message. I don't like this :(" ]);

        $projectName = 'girlfriend-xkcv';

        $auth = new StorageClient([
            'keyFile' => json_decode(file_get_contents('../girlfriend.json'), true),
            'keyFilePath' => '../girlfriend.json',
            'projectId' => 'girlfriend-xkcv'
        ]);

        $session_client = new SessionsClient();

        $session = $session_client->sessionName($projectName, uniqid());
        $languageCode = "en";

        // create text input
        $textInput = new TextInput();
        $textInput->setText($request->message);
        $textInput->setLanguageCode($languageCode);

        // create query input
        $queryInput = new QueryInput();
        $queryInput->setText($textInput);

        // get response and relevant info
        $response = $session_client->detectIntent($session, $queryInput);
        $queryResult = $response->getQueryResult();

        $user_count = UserCounter::where('id', 1)->first();
        $user_count->update(['talk_count'=> $user_count->talk_count+1]);


//        dd($queryResult);
//        $queryText = $queryResult->getQueryText();
//        $intent = $queryResult->getIntent();
//        $displayName = $intent->getDisplayName();
//        $confidence = $queryResult->getIntentDetectionConfidence();
//        $fulfilmentText = $queryResult->getFulfillmentText();



        $reply = $queryResult->getFulfillmentText();

        return view('index', compact('reply'));
    }









}
