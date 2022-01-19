<?php

namespace Drupal\ckeditor_groupaccordion\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Groupaccordion" plugin, with a CKEditor.
 *
 * @CKEditorPlugin(
 *   id = "groupaccordion",
 *   label = @Translation("Groupaccordion Plugin")
 * )
 */
class Groupaccordion extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface {

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
    return drupal_get_path('module', 'ckeditor_groupaccordion') . '/js/plugins/groupaccordion/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $iconImage = drupal_get_path('module', 'ckeditor_groupaccordion') . '/js/plugins/groupaccordion/images/icon.png';

    return [
      'Groupaccordion' => [
        'label' => 'Add Groupaccordion Widget',
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
