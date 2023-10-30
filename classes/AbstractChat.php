<?php
namespace classes;

use Model\Message;

class AbstractChat{

    const ROLE = "role";
    const CONTENT = "content";
    const USER = "user";
    const SYS = "system";
    const ASSISTANT = "assistant";

    public $char='default';
    public $DB;
    public $apiKey = null;
    public $logDir = __DIR__.'/../logs';


    protected function prepareData($user_id, $msg){
        
        $this->MessageToDB($user_id, $msg);

        $characterPrompt = $this->getCharacterPrompt($this->char);

        $history = [];
        if( !empty($characterPrompt) ){
            $history[] = [self::ROLE => self::SYS, self::CONTENT => $characterPrompt];
        }

        $history = array_merge($history, $this->get_history($user_id)); 

        $history_count = count($history);
        if( $history_count >15 ){
            $minus = $history_count-($history_count-15);
            $hewHistory = array_reverse($history);
            $newHistory = array_reverse(array_slice($hewHistory, 0, $minus));
            $newHistory[0] = $history[0];
            $arHistory = $newHistory;
        }else{
            $arHistory = $history;
        }       

        $chatParams = $this->load_params();

        return ['params'=>$chatParams, 'history'=>$arHistory];
    }
   

    public function get_history($user_id, $history=[]){

        $char = str_replace(' ', '_', strtolower($this->char));

        $dbRes = Message::where(['user_id'=>$user_id, 'char_id'=>$char])->get()->toArray();

        if( !empty($dbRes) ){
            foreach ($dbRes as $row ) {
                if( !empty($row['human']) ){
                    $history[] = [self::ROLE => self::USER, self::CONTENT => $row['human'] ];
                }
                if( !empty($row['ai']) ){
                    $history[] = [self::ROLE => self::ASSISTANT, self::CONTENT => $row['ai'] ];
                }    
            } 
            
            return $history;
        }

    }


    public function delete_history($user_id){
        
        $char = str_replace(' ', '_', strtolower($this->char));
        return Message::where(['user_id'=>$user_id, 'char_id'=>$char])->delete();       
    }


    //ai settings to json file
    public function save_settings($request){

        $chat_settings['temperature'] = $request['temperature'];
        $chat_settings['max_tokens'] = $request['max_tokens']?: '';
        $chat_settings['frequency_penalty'] = $request['frequency_penalty'] ?:'';
        $chat_settings['presence_penalty'] = $request['presence_penalty'] ?: '';  
        $chat_settings['user_name'] = $request['user_name'] ?: '';   
        $chat_settings['nswf'] = $request['nswf'] ?: '';  
        $chat_settings['model'] = $request['model'] ?: '';
        $json = json_encode($chat_settings);    
        file_put_contents(__DIR__.'/../chat_settings.json', $json);

        $_SESSION['flush_message'] = 'Settings successfuly saved';
        return json_encode(['status'=>'success']);
    }


    public function get_settings(){
        return file_get_contents(__DIR__.'/../chat_settings.json');
    }


    protected function getCharacterPrompt($char_name){

        $char = str_replace(' ', '_', strtolower($char_name));

        $filename = CHARACTERS_DIR.'/'.$char.'.json';

        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if( file_exists($filename) && $fileExt=='json' ) { 

            $charParamsJson = file_get_contents($filename);
            $charParams = json_decode($charParamsJson, true);

            $prompt = "";
            
            if( !empty($charParams['system_prompt']) ){
                $prompt = $charParams['system_prompt'];
            }     
  
            if( !empty($charParams['description']) ){
                $prompt.= "\n"."Description:". $charParams['description'];
            }

            if( !empty($charParams['personality']) ){
                $prompt.= "\n"."Personality:". $charParams['personality'];
            }

            if( !empty($charParams['scenario']) ){
                $prompt.= "\n"."Scenario:". $charParams['scenario'];
            }

            if( !empty($charParams['first_mes']) ){
                $prompt.= "\n"."First message: ".$charParams['first_mes'];
            }

            if($prompt){
                $prompt = str_replace('{{char}}', $charParams['char_name'], $prompt);
                $prompt = str_replace('{{user}}', $charParams['user_name'], $prompt);
            }

            return $prompt;
        }
    }


    // load parameters from settings
    protected function load_params()
    {       
        $defParams = [];

        $chatParamsFile = __DIR__ . '/../chat_settings.json';

        if ( file_exists($chatParamsFile) ) {

            $chatParamsJson = file_get_contents($chatParamsFile);
            $chatParams = json_decode($chatParamsJson, true);

            return $chatParams;
        }
        
        return $defParams;
    }


    //add messages to db
    protected function MessageToDB($user_id, $humanMsg=null, $aiMsg=null) {

        $char = str_replace(' ', '_', strtolower($this->char));

        if(!empty($humanMsg)){
            Message::create([
                'user_id'=>$user_id,
                'char_id'=>$char,
                'human'=>$humanMsg,
                'ai'=>''
            ]);
        }

        if(!empty($aiMsg)){       
            Message::create( [
                'user_id'=>$user_id,
                'char_id'=>$char,
                'ai'=>$aiMsg,
                'human'=>''
            ]);
        }        
    }

}