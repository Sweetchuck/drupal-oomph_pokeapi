<?php

declare(strict_types = 1);

namespace Drupal\oomph_pokeapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Pager\PagerManagerInterface;
use Drupal\Core\Url;
use Drupal\oomph_pokeapi\PokeApi\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Route controller.
 */
class EndpointPokemonList extends ControllerBase {

  /**
   * PokeAPI client.
   */
  protected Client $pokeApi;

  /**
   * Required for the pager.
   */
  protected RequestStack $requestStack;

  /**
   * Pager manager instance.
   */
  protected PagerManagerInterface $pagerManager;

  /**
   * How many items should be visible on one page.
   */
  protected int $pagerLimit = 50;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('oomph_pokeapi.client'),
      $container->get('request_stack'),
      $container->get('pager.manager'),
    );
  }

  /**
   * Creates a new EndpointPokemonList.
   */
  public function __construct(
    Client $pokeApi,
    RequestStack $requestStack,
    PagerManagerInterface $pagerManager,
  ) {
    $this->pokeApi = $pokeApi;
    $this->requestStack = $requestStack;
    $this->pagerManager = $pagerManager;
  }

  /**
   * Page content callback.
   */
  public function body(): array {
    $page = $this
      ->requestStack
      ->getCurrentRequest()
      ->query
      ->get('page', 0);

    try {
      $response = $this->pokeApi->endpointPokemonListGet([
        'pager' => [
          'offset' => $page * $this->pagerLimit,
          'limit' => $this->pagerLimit,
        ],
      ]);
    }
    catch (GuzzleException) {
      $this->messenger()->addError($this->t('Pokémons are not available'));

      return [];
    }

    $this->pagerManager->createPager(
      (int) ($response['count'] ?? 0),
      $this->pagerLimit,
    );

    $body = [
      'pokemons' => [
        'list' => [
          '#type' => 'table',
          '#header' => [
            'id' => $this->t('ID'),
            'name' => $this->t('Name'),
          ],
          '#empty' => $this->t('There are no Pokémons'),
          '#rows' => [],
        ],
        'pager' => [
          '#type' => 'pager',
        ],
      ],
    ];

    foreach ($response['results'] ?? [] as $pokemon) {
      $matches = [];
      preg_match(
        '@/(?P<id>\d+)/$@',
        (string) ($pokemon['url'] ?? ''),
        $matches,
      );
      $name = $pokemon['name'] ?? $this->t('Unknown');
      $body['pokemons']['list']['#rows'][] = [
        'data' => [
          [
            'data' => [
              '#type' => 'markup',
              '#markup' => $matches['id'] ?? '?',
            ],
          ],
          [
            'data' => [
              '#type' => 'link',
              '#title' => $name,
              '#url' => Url::fromRoute('oomph_pokeapi.endpoint.pokemon', ['pokemon' => (string) $name]),
            ],
          ],
        ],
      ];
    }

    return $body;
  }

}
