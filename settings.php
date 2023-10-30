<?php 
require("header.php");
use classes\User;

$user = User::auth_user();
if( !User::check_auth()){
   User::logout();
}?>

<div class="container wrapper background">
   <?php require("navbar.php") ?>

    <?php
        $chatParamsJson = file_get_contents(__DIR__.'/chat_settings.json');
        $chatParams = json_decode($chatParamsJson, true);
     ?>

    <form method="POST" class="settings-form row justify-content-center pb-3" action="api.php"> 
        <div class="col-md-6 col-10">
        <h4>Settings</h4>

        <?php flush_messages('success'); ?>

        <input type="hidden" name="save" value="chat_settings">
        <div class="form-group">
            <label>Temperature</label>
            <input type="text" name="temperature" class="form-control" value="<?php echo $chatParams['temperature']?>">
        </div>

        <div class="form-group">
            <label>
                Max tokens
            </label>
            <input type="text" type="number" name="max_tokens" class="form-control" value="<?php echo $chatParams['max_tokens']?>">
        </div>

        <div class="form-group">
            <label>
            Frequency penalty
            </label>
            <input type="number" name="frequency_penalty" step="0.1" class="form-control" value="<?php echo $chatParams['frequency_penalty']?>">
        </div>

        <div class="form-group">
            <label>
            Presence penalty
            </label>
            <input type="number" name="presence_penalty" step="0.1" class="form-control" value="<?php echo $chatParams['presence_penalty']?>">
        </div>

        <div class="form-group">
            <label>
            Your name           
            </label>
            <input type="text" name="user_name" class="form-control" value="<?php echo $chatParams['user_name']?>">
        </div>

        <div class="form-group">
            <label>
            Show NSWF Characters            
            <input type="hidden" value="">
            <input type="checkbox" name="nswf" <?php if(!empty($chatParams['nswf'])){ echo 'checked';} ?> value="1">
            </label>
        </div>

        <div class="form-group">
            <label>AI Model</label>
            <select class="form-control" name="model">
            <option value="">Select Model</option>
            <option value="pygmalionai/mythalion-13b" <?php if($chatParams['model']=='pygmalionai/mythalion-13b'): ?>selected<?php  endif?> >pygmalionai/mythalion-13b</option>
            <option value="gryphe/mythomax-l2-13b" <?php if($chatParams['model']=='gryphe/mythomax-l2-13b'): ?>selected<?php  endif?> >gryphe/mythomax-l2-13b</option>
            <option value="nousresearch/nous-hermes-llama2-13b" <?php if($chatParams['model']=='nousresearch/nous-hermes-llama2-13b'): ?>selected<?php  endif?>  >nousresearch/nous-hermes-llama2-13b</option>
            <option value="mancer/weaver" <?php if($chatParams['model']=='mancer/weaver'): ?>selected<?php  endif?>  >mancer/weaver</option>
            <option value="mistralai/mistral-7b-instruct" <?php if($chatParams['model']=='mistralai/mistral-7b-instruct'): ?>selected<?php  endif?>  >mistralai/mistral-7b-instruct</option>
            <option value="phind/phind-codellama-34b-v2" <?php if($chatParams['model']=='phind/phind-codellama-34b-v2'): ?>selected<?php  endif?>  >phind/phind-codellama-34b-v2</option>
            <option value="meta-llama/llama-2-13b-chat" <?php if($chatParams['model']=='meta-llama/llama-2-13b-chat'): ?>selected<?php  endif?>>meta-llama/llama-2-13b-chat</option>
            <option value="meta-llama/llama-2-70b-chat" <?php if($chatParams['model']=='meta-llama/llama-2-70b-chat'): ?>selected<?php  endif?>>meta-llama/llama-2-70b-chat</option>
            <option value="google/palm-2-chat-bison" <?php if($chatParams['model']=='google/palm-2-chat-bison'): ?>selected<?php  endif?>>google/palm-2-chat-bison</option>
            <option value="openai/gpt-3.5-turbo" <?php if($chatParams['model']=='openai/gpt-3.5-turbo'): ?>selected<?php  endif?>>openai/gpt-3.5-turbo</option>
            <option value="openai/gpt-3.5-turbo-16k" <?php if($chatParams['model']=='openai/gpt-3.5-turbo-16k'): ?>selected<?php  endif?>>openai/gpt-3.5-turbo-16k</option>
            <option value="openai/gpt-4" <?php if($chatParams['model']=='openai/gpt-4'): ?>selected<?php  endif?>>openai/gpt-4</option> 
            </select>
        </div>

        <div class="form-group">
            <label>
                <button type="submit" class="btn btn-success">Save</button>
            </label>
        </div>
        </div>
    </form>

</div>    
<?php require("footer.php")?>