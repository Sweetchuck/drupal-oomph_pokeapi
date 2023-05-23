<?php

declare(strict_types = 1);

namespace Drupal\oomph_pokeapi\Element;

use Drupal\Core\Render\Element\ElementInterface;
use Drupal\Core\Render\Element\RenderElement;

/**
 * Creates Pokémon element.
 *
 * @RenderElement("oomph_pokeapi_pokemon")
 */
class Pokemon extends RenderElement implements ElementInterface {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#theme' => 'oomph_pokeapi_pokemon',
      '#pokemon' => NULL,
    ];
  }

}
