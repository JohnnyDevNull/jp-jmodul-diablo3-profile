### Description
This is a module for the content management system Joomla. It allows you to display a Diablo 3 Battlenet-Account on your homepage.

For more preview see [preview.png](https://github.com/JohnnyDevNull/jp-jmodul-diablo3-profile/blob/master/preview.png) or more information see [http://jplace.de](http://jplace.de/index.php/10-blog/joomla/5-modul-diablo-3-profilanzeige)

### Backend parameters
* Diablo 3 logo on / off
* Choose your server zone
* Battletag name
* Battletag ID
* Hero ID
* Profile request caching
  * On active caching the request to the Diablo 3 API will be saved as .career files and will be used for further frontend display instead of making a call on each page load.
* Cache time
  * Controls the refresh rate of the .career files.

### Frontend display
* Battletag
* Paragon
* Per hero
  * Name
  * Level
  * Class
* Summary account kills
  * Monsters
  * Elite
  * Hardcore
* Integrated Languages
  * German
  * English