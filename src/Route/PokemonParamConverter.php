<?php

declare(strict_types = 1);

namespace Drupal\oomph_pokeapi\Route;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\oomph_pokeapi\PokeApi\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Routing\Route;

/**
 * Converts a Pokémon ID or name into a fully loaded array.
 */
class PokemonParamConverter implements ParamConverterInterface {

  /**
   * HTTP Client.
   */
  protected Client $pokeApi;

  /**
   * Constructs a new PokemonParamConverter.
   */
  public function __construct(Client $pokeApi) {
    $this->pokeApi = $pokeApi;
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return ($definition['type'] ?? NULL) === 'oomph_pokeapi:pokemon';
  }

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    try {
      return $this->pokeApi->endpointPokemonGet($value);
    }
    catch (GuzzleException) {
      return NULL;
    }
  }

}
