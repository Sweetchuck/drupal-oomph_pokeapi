# Drupal PokeAPI integration

This module integrates [PokeAPI](https://pokeapi.co/) into Drupal.


## Requirements

* PHP 8.1
* Drupal 10


## Installation

1. Run `cd YOUR_DRUPAL10_PROJECT_ROOT`
2. Run `composer config 'repositories.drupal/oomph_pokeapi' 'git' 'https://github.com/Sweetchuck/drupal-oomph_pokeapi.git'`
3. Run `composer require 'drupal/oomph_pokeapi:1.x-dev'`
4. Run `./vendor/bin/drush pm:enable oomph_pokeapi`
5. Open your D10 website in a browser and go to `/oomph-pokeapi/pokemon` path.


## Implemented endpoints

* GET https://pokeapi.co/api/v2/pokemon/
* GET https://pokeapi.co/api/v2/pokemon/{id}/

[PokeAPI documentation]


[PokeAPI documentation]: https://pokeapi.co/docs/v2
