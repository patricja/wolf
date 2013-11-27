Wolf - utveckling av ett PHP-baserat och MVC-inspirerat ramverk
=================================================================

Skapat av Patric Jansson, patric_jansson@spray.se som en del i kursen "Databasdrivna webbapplikationer med PHP och MVC" på Blekinge Tekniska Högskola.
Baserat på ramverket Lydia av Mikael Roos, lärare på BTH.


Specifikationer
---------------

* PHP, minst version 5.2.4
* Katalogen site/data ska skapas och ges rättigheterna 777
* sqlite

Installation
------------

För att installera modulerna i Wolf laddar du ner hela ramverket från GitHub och laddar upp på din server.
Du skapar därefter katalogen site/data som behövs för sqlite genom: 
1# cd wolf 
2# mkdir site/data
3# chmod 777 site/data

Därefter kanske du behöver anpassa .htaccess filen på ett liknande sätt:
# Must use RewriteBase on www.student.bth.se, Rewritebase for url /~mos/test is /~mos/test/
  
Öppna upp en webbläsare och navigera till katalogen där du installerade. 

Du hamnar i index controllern, där klickar du på länken module/install för att skapa databaser och test innehåll.

Klart!

Användning
----------

När ramverket är installerat och klart kan du klicka på Logga in längst upp till höger. Användarnamnet för administratörskontot är root och lösenordet root. Det finns också en användare som är utan administratörsrättigheter som tillhör gruppen user. Den användaren kan logga in som doe med lösenord doe.

I index-kontrollern listas alla kontrollers och deras metoder i vänsterspalten. Det finns också en inbyggd dokumentation i ramverket som ligger i kontroller `module`. Här listas alla moduler i vänsterspalten, klicka på respektive modul för att läsa mer om den.

Här följer lite exempel på vad du kan göra:

### Ändra logo, webbplatsens titel, footer och navigeringsmeny ###

Du kan ändra titel, footer och navigeringsmeny från config.php filen som ligger i site mappen.
Här kan du ändra tema / utseende via $wo->config['theme'] = array. Välj mellan mytheme eller swe_theme.
Du ändrar navigeringmeny via 'menu_to_region' => array. Välj mellan sample-menu and small-samlpe-menu.
Här kan du också ändra header och footer via 'data' => array
Loggan ändras genom att ändra 'logo' variabeln till ditt filnamn samt lägga till bilden i ditt valda tema site/themes/..../logo.jpg


Nedan följer en snippet av config filen.

/**
	 * Settings for the theme.
	 */
$wo->config['theme'] = array(
  // The name of the theme in the theme directory
  'path' => 'site/themes/swe_theme', // choose from 2 themes: mytheme and swe_theme
  'parent' => 'themes/bootstrap',
  'name' => 'grid',
  'stylesheet' => 'style.css', // Main stylesheet to include in template files
  'template_file' => 'index.tpl.php', // Default template file, else use default.tpl.php
  
  'menu_to_region' => array('sample-menu'=>'navbar'), //choose from two menus: sample-menu and small-samlpe-menu
  'data' => array(
    'header' => 'Wolf',
    'slogan' => 'A PHP-based MVC-inspired CMF',
    'favicon' => 'logo_80x80.png',
    'logo' => 'wolf.jpeg',
    'logo_width' => 80,
    'logo_height' => 80,
    'footer' => '<p>Lydia &copy; by Mikael Roos (mos@dbwebb.se) modified by Patric</p>',
  ),
);


### Skapa blogg inlägg och sidor ###

När du installerar ramverket finns redan en exempel-kontroller för blog, gästbok och sida. 
För att skapa nya blogginlägg eller en ny sida så klickar man på content i navigeringsmeny och fyller i formuläret, under type väljer man antigen blog eller page för att skapa materialet.

Nedan är några filters som kan anpassa innehållet i ditt inlägg eller sida. T.ex. anger bbcode att du inom taggarna [b]kan skriva text i bold eller annat[/b]

* htmlpurify
* bbcode
* plain

### ACP ###

Som inloggad root användare har man tillgång till ACP - admin control panel. Därifrån ges möjlighet att ändra och ta bort innehåll.
Ta bort användare och lägga till användare, och ta bort och lägga till grupper.
