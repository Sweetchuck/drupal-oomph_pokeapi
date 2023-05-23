<?php

declare(strict_types = 1);

namespace Drupal\oomph_pokeapi\PokeApi;

use GuzzleHttp\ClientInterface;

/**
 * PokeAPI client.
 */
class Client {

  /**
   * HTTP Client.
   */
  protected ClientInterface $httpClient;

  /**
   * Default base URL.
   */
  protected string $baseUrl = 'https://pokeapi.co/api/v2';

  /**
   * Constructs a new PokeAPI client.
   */
  public function __construct(ClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * Fetches data from endpoint "GET /pokemon".
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function endpointPokemonListGet(array $options = []): array {
    $uri = "{$this->baseUrl}/pokemon";
    $query = [];
    if (!empty($options['pager'])) {
      $query['offset'] = $options['pager']['offset'] ?? 0;
      $query['limit'] = $options['pager']['limit'] ?? 20;
    }

    if ($query) {
      $uri .= '?' . http_build_query($query);
    }

    $response = $this->httpClient->request('GET', $uri);
    $body = (string) $response->getBody();

    return json_decode($body, TRUE);
  }

  /**
   * Fetches data from endpoint "GET /pokemon/{id}".
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function endpointPokemonGet(int|string $pokemon_id): array {
    $uri = "{$this->baseUrl}/pokemon/" . urlencode((string) $pokemon_id);

    $response = $this->httpClient->request('GET', $uri);
    $body = (string) $response->getBody();

    return json_decode($body, TRUE);
  }

}
