<div id="main" class="section group">
    <div id="search_box" class="col span_2_of_12 matchheight">
        <label for="search">Drug Search</label>
        <input id="search" type="text">
        <div id="result_box">

        </div>
    </div>
    <div id="result_box" class="col span_10_of_12 matchheight">
        <h2 id="name" class="center"></h2>
        <div id="interactions">
            <h3>Interactions</h3>
            <p></p>
        </div>
        <div id="history">
            <h3>Drug History</h3>
            <p></p>
        </div>
        <div id="similar">
            <h3>Similar Drugs</h3>
            <p></p>
        </div>
    </div>
</div>
<style type="text/css">
    #search_box
    {
        border-right: 4px solid #134f5c;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.matchheight').matchHeight();
    });
</script>
<?=print_r($drugs) ?>