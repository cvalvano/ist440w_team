<h1 class="center">Drug Lookup</h1>
<div id="main" class="section group">
    <div id="search_box" class="col span_2_of_12 matchheight">
        <label for="search">Drug Search</label>
        <input id="search" type="text">
        <a href="javascript:searchDrugs()">Search</a>
        <div id="results_box">

        </div>
    </div>
    <div id="result_box" class="col span_10_of_12 matchheight">
        <h2 id="name" class="center"></h2>
        <div id="information">
            <h3>Information</h3>
            <p></p>
        </div>
        <div id="interactions">
            <h3>Interactions</h3>
            <p></p>
        </div>
        <div id="history">
            <h3>Drug History</h3>
            <p></p>
        </div>
    </div>
</div>
<style type="text/css">
    #result_box
    {
        border-left: 4px solid #134f5c;
    }
    #result_box h2, #result_box div
    {
        padding-left: 20px;
    }
</style>
<script type="text/javascript">
    var drugs = <?=json_encode($drugs)?>
        , brands = <?=json_encode($brands)?>
        , interactions = <?=json_encode($interactions)?>
        , severities = <?=json_encode($severities)?>;
    $(document).ready(function(){

    });
    function searchDrugs()
    {
        var search_text = new RegExp($('#search').val().toUpperCase(), 'g');
        var matches = [];
        $.each(drugs,function(){
            if (null != this['drug_name'].toUpperCase().match(search_text)) {
                matches.push(this);
            }
        });
        $.each(brands, function(){
            if (null != this['brand_name'].toUpperCase().match(search_text)){
                matches.push({
                    drug_id : this['drug_id']
                    , drug_name : this['brand_name']
                    , drug_description : this['brand_description']
                });
            }
        });
        var results_box = $('#results_box');
        results_box.empty();
        $.each(matches,function(){
            results_box.append('<a href="javascript:showDrug('+this['drug_id']+')">'+this['drug_name']+'</a><br>');
        });
    }
    function showDrug (id)
    {
        var drug = [];
        $.each(drugs,function(){
            if (this['drug_id'] == id) {
                drug = this;
            }
        });
        var interaction_text = '';
        $.each(interactions,function(){
            if (null !=this['drug_ids'].match(id)) {
                interaction_text += '<span class="orange">'+severities[this['interaction_severity']-1]['severity_description']+'</span> - '+ this['interaction_description']+'<br><br>';
            }
            $('#interactions').children('p').html(interaction_text);
        });
        $('#name').text(drug['drug_name']);
        $('#information').children('p').html(drug['drug_description']);
        $('#history').children('p').html(drug['drug_history']);
    }
</script>
