<?php
namespace classes;

use DirectoryIterator;

class Character
{
    public function getCharacters() {
        $characters = [];

        $files = new DirectoryIterator(CHARACTERS_DIR);

        $chatParamsFile = __DIR__ . '/../chat_settings.json';
        if (file_exists($chatParamsFile)) {
            $params = json_decode(file_get_contents($chatParamsFile), true);
        } else {
            $params = [];
        }

        if(!empty($files)) {
            
            foreach ($files as $file) {
                if ($file->isFile() && $file->getExtension() === 'json') {
                    $character = json_decode(file_get_contents($file->getPathname()), true);
                    
                    if ( !empty($character) && is_array($character)  &&  (  !empty($params['nswf']) || ( $character['nswf'] == $params['nswf'] ) )   ){

                        $characters[] = $character;
                    }
                    
                }
            }
        }

        return $characters;
    }


    public function getCharacter($char_name)
    {
        $char_name = strtolower($char_name);
        $filename = CHARACTERS_DIR . '/' . str_replace(' ', '_', $char_name) . '.json';
        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ( file_exists($filename) && $fileExt=='json' ) {
            $charParamsJson = file_get_contents($filename);
            return json_decode($charParamsJson, true);
        }
    }


    public function showCharacter($character){
        $char_img = '';
        $char_image = '';

        if(!empty($character['char_image'])){
            $char_img = basename(CHARACTERS_DIR).'/'.$character['char_image'];
            $char_image =  'style="background-image:url('.$char_img.')"';
        }
    
        $char_name = strtolower($character['name']);
   
        $htmlTable = '<div class="col-lg-2 col-md-3 col-sm-6 col-6 char-item-wrapp"><div class="char-item">
        <a class="chat-link" href="index.php?char_id='.$char_name.'">
            <div class="char-img" '.$char_image.'>'.$character['char_name'].'</div> 
            <div>'.$character['char_name'].'</div>       
        </a>
        
        <a class="char-edit-link" href="character.php?char_name='.$char_name.'">Edit</a>
        </div></div>';
        return $htmlTable;    
    }


    public function save($arData)
    {
        $character = [
            'char_name' => trim($arData['char_name']),
            'name' => trim(strtolower(str_replace(' ', '_', $arData['char_name']))),
            'personality' => '',
            'scenario' => trim($arData['scenario']),
            'first_mes' => trim($arData['first_mes']),
            'system_prompt' => trim($arData['system_prompt']),
            'user_name' => trim($arData['user_name']),
            'nswf' => !empty($arData['nswf']) ? 1 : 0,
        ];
    
        if (!empty($arData['description'])) {
            $character['personality'] = "Description: " . trim($arData['description']) . "\n";
        }
    
        $char_file = $character['name'] . '.json';
        $charFilePath = CHARACTERS_DIR . '/' . $char_file;
    
        if (!empty($arData['files']['char_image']['name'])) {
            $resUpload = $this->uploadImage($arData['files']['char_image'], CHARACTERS_DIR, $character['name'], 1000000);
    
            if ($resUpload['Success'] && $resUpload['Filename']) {
                $character['char_image'] = $resUpload['Filename'];
            }
        }
    
        $json = json_encode($character, JSON_UNESCAPED_UNICODE);
        file_put_contents($charFilePath, $json);
    
        $_SESSION['flush_message'] = 'Character successfully saved';
    
        return json_encode(['status' => 'success']);
    }


    public function removeCharacter($char_name)
    {
        $char_file = str_replace(' ', '_', strtolower($char_name)) . '.json';
        @unlink(CHARACTERS_DIR . '/' . $char_file);
    }


    public function import($request){

        $fileCont = file_get_contents($request['char_file']['tmp_name']);
        $arData = json_decode($fileCont, true);

        $this->save($arData);    

        return json_encode(['status'=>'success']);
    }


    protected function uploadImage($file, $uploadPath, $char_name, $maxFileSize=1000000)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['Error' => $file['error']];
        }

        $filename = $file['name'];
        $tmpFilePath = $file['tmp_name'];
        $fileSize = $file['size'];

        if ($fileSize > $maxFileSize) {
            return ['Error' => 'Error max file size'];
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return ['Error' => 'Error file type'];
        }

        $uploadFilePath = $uploadPath . '/' . $char_name . '.' . $fileExtension;

        if (move_uploaded_file($tmpFilePath, $uploadFilePath)) {
            return [
                'Success' => 'Success file uploaded',
                'Filename' => $char_name . '.' . $fileExtension
            ];
        } else {
            return ['Error' => 'Error upload'];
        }
    }

}