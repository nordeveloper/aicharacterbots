<?php 
require(__DIR__."/header.php");
use classes\Character;
use classes\User;

if( !User::check_auth()){
    User::logout();
}

$character = new Character();
$charParams['char_name'] = '';
$charParams['system_prompt'] = '';
$charParams['description'] = '';
$charParams['personality'] = '';
$charParams['scenario'] = '';
$charParams['first_mes'] = '';
$charParams['char_image'] = '';
$charParams['user_name'] = '';


if( !empty($_REQUEST['char_name']) ){            
    $char = $character->getCharacter($_REQUEST['char_name']);

    if( !empty($char) ){
        $charParams = $char;

        if( !empty($charParams['char_persona']) ){
            $charParams['personality'] = $charParams['char_persona']; 
        } 
        
        if( !empty($charParams['description']) ){
            $charParams['personality'].= "\n\nDescription: ".$charParams['description'];
        }

        if( !empty($charParams['world_scenario']) ){
            $charParams['scenario'] = $charParams['world_scenario']; 
        }

        if( !empty($charParams['char_greeting']) ){
            $charParams['first_mes'] = $charParams['char_greeting']; 
        }
    }
}
?>
<div class="container wrapper background">
    <?php require("navbar.php") ?>

    <form method="POST" class="settings-form row justify-content-center pb-3" action="api.php" enctype="multipart/form-data">

    <div class="col-10">

    <?php if(!empty($charParams['char_name'])): ?>
    <h4>Edit Character</h4>
    <?php else: ?>
        Add Character
    <?php endif?>

        <?php echo flush_messages('success'); ?>

        <input type="hidden" name="save" value="character">

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Char Name</label>
                    <input type="text" name="char_name" class="form-control" value="<?php echo $charParams['char_name']?>">
                </div>

                <div class="form-group">
                    <label>Your Name:</label>
                    <input type="text" name="user_name" class="form-control" value="<?php echo $charParams['user_name']?>">
                </div>  

                <div class="form-group">
                    <label> NSWF Character:          
                    <input type="hidden" value="">
                    <input type="checkbox" name="nswf" <?php if(!empty($charParams['nswf'])){ echo 'checked';} ?> value="1">            
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Char Image</label>
                    <input type="file" name="char_image" class="form-control">

                    <?php if(!empty($charParams['char_image'])): ?>
                    <div>
                        <img style="width: 150px;" src="<?php echo basename(CHARACTERS_DIR).'/'. $charParams['char_image']?>">
                    </div>
                    <?php endif?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

            <div class="form-group">
                <label>Personality: <span>{{char}} well be replaced with Char Name</span></label>
                <textarea type="text" name="personality" rows="10" class="form-control"><?php echo $charParams['personality']?></textarea>
            </div>

            <div class="form-group">
                <label>Scenario: <span>{{char}} well be replaced with Char Name</span></label>
                <textarea type="text" name="scenario" rows="8" class="form-control"><?php echo $charParams['scenario']?></textarea>
            </div>

            <div class="form-group">
                <label>First message: <span>{{char}} well be replaced with Char Name</span></label>
                <textarea type="text" name="first_mes" rows="6" class="form-control"><?php echo $charParams['first_mes']?></textarea>
            </div>

            <div class="form-group">
                <label>
                    AI System Prompt instruction: <span>{{char}} well be replaced with Char Name</span>
                </label>
                <textarea type="text" name="system_prompt" rows="10" class="form-control"><?php echo $charParams['system_prompt']?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Save</button>

                <?php if( !empty($charParams['char_name']) ): ?>
                <a class="btn btn-danger pull-right" onClick="confirm_remove();" href="api.php?remove=Y&char_name=<?php echo strtolower($charParams['name'])?>">Remove</a>
                <?php endif ?>
            </div>

            </div>
        </div>          

    </form>
    
    </div>
    
</div>    
<?php require("footer.php")?>