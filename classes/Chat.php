<?php
namespace classes;

use classes\AiRequest;
use classes\AbstractChat;
use Exception;

class Chat extends AbstractChat{

    public $temperature = 0.7;
    public $max_tokens = 100;
    public $frequency_penalty = 0.5;
    public $presence_penalty = 0.5;   
    public $apiKey;

     /**
     * Send a message to the user.
     *
     * @param int $user_id The ID of the user.
     * @param string $msg The message to send.
     * @throws Exception When an error occurs.
     * @return string The JSON-encoded response.
     */

    public function Send($user_id, $msg){

        $char = str_replace(' ', '_', strtolower($this->char));

        $preparedData = $this->prepareData($user_id, $msg);
        $chatParams = $preparedData['params'];
        $arHistory = $preparedData['history'];

         $opts = [
           'model' => $chatParams['model'],
           'messages' => $arHistory,
           'temperature' => (float) $chatParams['temperature'],
           'max_tokens' => (int) $chatParams['max_tokens'],
           'frequency_penalty' => (float) $chatParams['frequency_penalty'],
           'presence_penalty' => (float) $chatParams['presence_penalty'],
           'top_p'=>0.9
        ];
   
        //  file_put_contents($this->logDir.'/logs_'.$this->user_id.'_'.$this->char.'.txt', print_r($opts, 1), FILE_APPEND);   
    
        try{
            $arData['bot_name'] = ucfirst($char);
            $arData['user_name'] = 'You';

            $airequest = new AiRequest($this->apiKey);
            $aiRespJson = $airequest->chat($opts);

            if(  !empty($aiRespJson) ){

                $arAIResp = json_decode($aiRespJson, 1);
   
                if(  !empty($arAIResp["choices"]) ){
    
                    $aiMsg = $arAIResp["choices"][0]['message']['content'];
        
                    $this->MessageToDB($user_id, null, $aiMsg);
    
                    $arData['text'] = $aiMsg; 
                    return json_encode($arData);
        
                }else{
    
                    file_put_contents($this->logDir.'/error.log', print_r($arAIResp, 1), FILE_APPEND);
                    return json_encode(['text'=>'ERROR, AI not response']);
                }

            }else{

                return json_encode(['text'=>'ERROR, AI not response']);
            }

        }catch(Exception $e){

            return json_encode(['text'=>$e->getMessage()]);
        }
    }

}