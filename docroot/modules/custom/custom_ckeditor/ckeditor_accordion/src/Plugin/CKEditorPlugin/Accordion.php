<?php

namespace Drupal\ckeditor_accordion\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Accordion" plugin, with a CKEditor.
 *
 * @CKEditorPlugin(
 *   id = "accordion",
 *   label = @Translation("Accordion Plugin")
 * )
 */
class Accordion extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface {

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
    return drupal_get_path('module', 'ckeditor_accordion') . '/js/plugins/accordion/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $iconImage = drupal_get_path('module', 'ckeditor_accordion') . '/js/plugins/accordion/images/icon.png';

    return [
      'Accordion' => [
        'label' => 'Add Accordion Widget',
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
