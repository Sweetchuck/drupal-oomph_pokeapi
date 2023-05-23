<?php

declare(strict_types = 1);

namespace Drupal\oomph_pokeapi\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Route controller.
 */
class EndpointPokemon extends ControllerBase {

  /**
   * Page title callback.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   Page title.
   */
  public function title(array $pokemon) {
    return $this->t(
      'Pokémon: @pokemon',
      [
        '@pokemon' => $pokemon['name'] ?? $this->t('Unknown'),
      ],
    );
  }

  /**
   * Page content callback.
   */
  public function body(array $pokemon): array {
    return [
      'pokemon' => [
        '#type' => 'oomph_pokeapi_pokemon',
        '#pokemon' => $pokemon,
      ],
    ];
  }

}
