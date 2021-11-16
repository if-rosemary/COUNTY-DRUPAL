<?php

namespace Drupal\ckeditor_bootstrap_grid\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "widgettemplatemenu" plugin.
 *
 * @CKEditorPlugin(
 *   id = "widgettemplatemenu",
 *   label = @Translation("CKEditor Template Menu Widgets"),
 *   module = "ckeditor_bootstrap_grid"
 * )
 */
class WidgetTemplateMenu extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'ckeditor_bootstrap_grid') . '/js/plugins/widgettemplatemenu/plugin.js';
  }

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
  public function getButtons() {
    return [
      'WidgetTemplateMenu' => [
        'image' => drupal_get_path('module', 'ckeditor_bootstrap_grid') . '/js/plugins/widgettemplatemenu/icons/widgettemplatemenu.png',
        'label' => $this->t('Add Template Menu'),
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
