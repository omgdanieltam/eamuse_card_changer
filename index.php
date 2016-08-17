<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>E-Amusement Card Changer</title>
<style type="text/css">
a:visited {color: blue;};
</style>
<script src="jquery-2.2.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	function getCurrentCard() {
		$('#current_card').load('card_edit.php?current=true');
		};
	$(function(){
		$('.change_card').click(function(){
		var card = $(this).text();
		$.ajax({
			type: "GET",
			url: 'card_edit.php',
			data:{change: card},
			success:function(response){
				getCurrentCard();
				}
			});
		});
	});
	getCurrentCard();  
});
</script>
</head>
<body>
<?php
// lists the cards
echo '<h2>Change cards:</h2>';
if ($handle = opendir('cards')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") 
		{	
			$card_contents = file_get_contents('cards/'.$entry, true);
			echo $entry.' - <a href="#" class="change_card">'.$card_contents.'</a><br />' ;
        }
    }

    closedir($handle);
}

// displays current card
echo '<div id="current_card" style="margin-bottom: 70px;"></div>';

// menu
echo '<h2>Card Editor:</h2>
<a href="card_edit.php?add=true">Add a new card</a><br />
<a href="card_edit.php?edit=true">Edit/Delete existing cards</a>
</body>
</html>';
?>