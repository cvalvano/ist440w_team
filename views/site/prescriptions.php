<?php

$this->title = 'Pharmaceuticals Portal';
?>
<h1 class="center">Your Prescriptions</h1>
<div class="section group">
    <div id="listbox" class="col span_2_of_12">
        <?php foreach($prescriptions as $prescription): ?>
        <a href="javascript:setPrescription(<?=$prescription['user_drug_id']?>)"><?=$prescription['drug_name']?></a><br>
        <?php endforeach; ?>
    </div>
    <div id="prescriptionbox" class="col span_10_of_12">
        <?php foreach($prescriptions as $prescription): ?>
        <div id="<?=$prescription['user_drug_id']?>" class="hidden_section" style="display: none">
            <h3 class="orange"><?=$prescription['drug_name']?></h3><br>
            Days
            <textarea id="days"><?=$prescription['prescription_days']?></textarea><br>
            Times
            <textarea id="days"><?=$prescription['prescription_times']?></textarea>
            <h4>Drug Interactions</h4>
            <?php foreach($interactions as $interaction): ?>
                <?php if (false !== strpos($interaction['drug_ids'],$prescription['drug_id'])): ?>
                    <?php
                    $drug_list = explode(',',$interaction['drug_ids']); $drug_name_array = [];
                    foreach ($drug_list as $drug){$drug_name_array[] = $drugs[$drug-1]['drug_name'];}
                    ?>
                <p><span class="orange"><?=$severities[$interaction['interaction_severity']-1]['severity_description']?></span> (<?=implode(',',$drug_name_array)?>) - <?=$interaction['interaction_description']?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    #prescriptionbox
    {
        border-left: 4px solid #134f5c;
        min-height: 150px;
    }
    #prescriptionbox h3, #prescriptionbox div
    {
        padding-left: 20px;
    }
    #prescriptionbox textarea
    {
        width: 75%;
        resize: none;
    }
</style>
<script type="text/javascript">
    function setPrescription (id)
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