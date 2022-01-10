<?php

namespace Drupal\facets_region_start\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Block w/ anchor tag allows jump link to send mobile users to facets region.
 *
 * @Block(
 *   id = "facets_region_start_block",
 *   admin_label = @Translation("Facets region start"),
 *   category = @Translation("Facets"),
 * )
 */
class FacetsRegionStart extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('<a id="facets-start"></a>'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

}
