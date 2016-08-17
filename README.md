# web_card_changer
Web based e-amusement card changer

#INTRODUCTION
Allows the use of a web browser to change the e-amusement card text file. Just point the tools to this file, then change it before you 'insert' the card.

#HOW IT WORKS
Using jQuery and PHP we can update the page to read new text files and it's contents and change the card based on that. PHP has access to change the text file itself, while jQuery is used to update the page (without reloading) the new card.

When a new card is selected, it will run another script in the background to read it's contents and replace the 'current-card' text file with it's own contents.

There is also an option to randomly create a new card. This will drop the name of the card into the folder 'cards'.

#SOURCES
https://jquery.com/ -- jQuery
