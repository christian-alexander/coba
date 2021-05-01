<select name="o" id="o">
	<option value="hu">hu</option>
    <option value="ha">ha</option>
</select>
<button onclick='he()'>dikdk</button>
<button onclick='hi()'>hi</button>
<script src="<?= base_url() ?>/jquery-3.6.0/jquery-3.6.0.min.js"></script>
	
<script>
function he(){
	$('#o').val('');
}
function hi(){
    console.log($('#o').val());
}
</script>