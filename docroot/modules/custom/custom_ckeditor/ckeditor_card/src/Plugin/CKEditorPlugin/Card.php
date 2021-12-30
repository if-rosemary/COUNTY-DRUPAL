<?php

namespace Drupal\ckeditor_card\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Card" plugin, with a CKEditor.
 *
 * @CKEditorPlugin(
 *   id = "card",
 *   label = @Translation("Card Plugin")
 * )
 */
class Card extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface {

  /**
   * {@inheritdoc}
   */
  public function getDependencies(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'ckeditor_card') . '/js/plugins/card/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $iconImage = drupal_get_path('module', 'ckeditor_card') . '/js/plugins/card/images/icon.png';

    return [
      'Card' => [
        'label' => 'Add Card Widget',
        'image' => $iconImage,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [];
  }

}
