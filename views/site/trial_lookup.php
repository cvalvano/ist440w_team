<?php

/* @var $this yii\web\View */

$this->title = 'Pharmaceuticals Portal';
$clinical_trials = $trials;
?>

<h1 class="center">Clinical Trial Lookup</h1>
<div class="section group">
    <div id="listbox" class="col span_2_of_12">
        <?php foreach($clinical_trials as $trial):  ?>
            <a href="javascript:setTrial(<?=$trial['clinical_trial_id']?>)"><?=$trial['clinical_trial_title']?></a><br>
        <?php endforeach;?>
    </div>
    <div id="trialbox" class="col span_10_of_12">
        <div id="0" class="hidden_section">
            <p></p>
            <p>
                Click on a link to the left to view more information.
            </p>
        </div>
        <?php foreach($clinical_trials as $trial):  ?>
        <div id="<?=$trial['clinical_trial_id']?>" class="hidden_section" style="display: none">
            <h3 class="orange"><?=$trial['clinical_trial_title']?></h3>
            <p>
                <?=$trial['clinical_trial_description']?>
            </p>
            <p>
                To view more information about <?=$trial['clinical_trial_title']?>, please
                <a target="_blank" href="<?=$trial['clinical_trial_link']?>">click&nbsp;here</a>.
            </p>
        </div>
        <?php endforeach;?>
    </div>
</div>
<style>
    #trialbox
    {
        border-left: 4px solid #134f5c;
        min-height: 150px;
    }
    #trialbox h3, #trialbox div
    {
        padding-left: 20px;
    }
</style>
<script type="text/javascript">
    function setTrial(id)
    {
        var sections = $('.hidden_section');
        $.each(sections,function(){
            if (id == $(this).attr('id')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
</script>