<?php
// list the cards
if(isset($_GET['change'])) // change the current card
{
file_put_contents('current-card.txt', $_GET['change']);
}
elseif(isset($_GET['add'])) // form to add a new card
{
echo '<html>
<script type="text/javascript">
function randomCard(length) {
    var chars = "0123456789abcdef";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}
function generate() {
    form.card.value = "e004" + randomCard(12);
}
</script>
<body><form action="card_edit.php" method="post" name="form">
Card ID (Starts with E004): <br /><input type="text" name="card" size="20" maxlength="16" value="'.$_GET['card'].'">&nbsp;&nbsp;<input type="button" class="button" value="Generate" onClick="generate();"<br /><br />
User: <br /><input type="text" name="user" size="20" maxlength="20" value="'.$_GET['user'].'"><br /><br />
<input type="button" onclick="location.href = \'index.php\';" value="Cancel">&nbsp&nbsp;<input type="submit"></form></body></html>';
}
elseif(isset($_POST['card'])) // creates a new card / edits a existing card
{
if(isset($_POST['delete']))
{
unlink('cards/'.$_POST['user'].'.txt');
header("Location: index.php");
exit();
}
file_put_contents('cards/'.strtolower($_POST['user']).'.txt', $_POST['card']);
header("Location: index.php");
exit();
}
elseif(isset($_GET['edit'])) // select a card to edit
{
$card_list = array(); // get all the cards, just so we can get a name
if ($handle = opendir('cards')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") 
		{	
			$card_contents = file_get_contents('cards/'.$entry, true);
			array_push($card_list, array('Name' => $entry, 'Contents' => $card_contents));
        }
    }

    closedir($handle);
}
echo '<html><head><script src="jquery-2.2.0.min.js"></script>';?>
<script type="text/javascript">
$(document).ready(function(){
	$(function(){
		$('#select').change(function(){
		var card = $(this).val();
		if(card != 0)
		{
			var split = card.split('|');
			var name = split[0].substr(0,split[0].length - 4);
			$("#card").val(split[1]);
			$("#user").val(name);
		}
		else
		{
			$("#card").val("");
			$("#user").val("");
		}
		});
	});
});
<?php echo'
</script>
</head><body>
<select id="select"><option value="0">Select a card:</option>';
foreach($card_list as $item)
{
echo '<option value="'.$item['Name'].'|'.$item['Contents'].'">'.$item['Name'].' - '.$item['Contents'].'</option>';
}
echo '</select><br /><br /><form action="card_edit.php" method="post" name="form">
Card ID (Starts with E004): <br /><input type="text" name="card" id="card" size="20" maxlength="16" value="'.$_GET['card'].'"><br /><br />
User: <br /><input type="text" name="user" size="20" maxlength="20" id="user" value="'.$_GET['user'].'" readonly><br /><br />
<input type="button" onclick="location.href = \'index.php\';" value="Cancel">&nbsp&nbsp;<input type="submit" name="delete" value="Delete">&nbsp&nbsp;<input type="submit" name="update" value="Update">
</form>';
echo '</body></html>';

}
elseif(isset($_GET['current'])) // displays current card
{
$card_list = array(); // get all the cards, just so we can get a name
if ($handle = opendir('cards')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") 
		{	
			$card_contents = file_get_contents('cards/'.$entry, true);
			array_push($card_list, array('Name' => $entry, 'Contents' => $card_contents));
        }
    }

    closedir($handle);
}
$current_card = file_get_contents('current-card.txt');
echo '<h2>Current card: </h2>';
$found_card = false;
foreach($card_list as $item)
{
if($item['Contents'] == $current_card)
{
echo $item['Name'].' - '.$current_card;
$found_card = true;
}
}
if(!$found_card)
{
echo 'Unknown - '. $current_card;
}
}
else // return to home page
{
header("Location: index.php");
exit();
}
?>