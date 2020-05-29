# Personal
this repository contains old software that I used to serve my website between 2014-2017. I develop it when I was young ~17 years old, it was one of the "greatest" achievements at that age.

by now, I decide to make it open source.

## Feature's
1. Easy to configure.
2. Multi & Custom themes system.
3. JSON files as databases: support custom structure's to fit with theme files, no SQL database needed! check `app/databases` for more details.
4. HTTP(s) routing: support `404 Not Found` custom handler, and callback function after handling the request.
5. `DEBUG_MODE` configuration support.
6. There exist some configurations for future features like uploading, SQL database, custom routing.


## Project Structure
* **App**: contains all business files used in the app.
  * **databases**: contains all JSON files that serve as database.
  * **frontend**: contains all themes directories.
    * **example**: an example template for themes.
  * **tools**: contains libraries and classes.
  * *router.php*: here where you define HTTP routes. check it, there are some examples.
* **bootstrap**: contains files that needed to boot & run the script.
  * *boot.php*: don't touch it.
  * *configs.php*: configuration file, here you can edit and apply your configuration.


## Disclaimer
I don't recommend using this script in production, I develop it when I was young and beginner so it could be vulnerable.

## Author 
- [Fares](https://Faares.com), the 17 years old guy.