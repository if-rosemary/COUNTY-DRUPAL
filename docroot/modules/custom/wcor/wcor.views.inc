<?php

/**
 * @file
 * Custom Views hooks.
 */

/**
 * Implements hook_views_data_alter().
 */
function wcor_views_data_alter(array &$data) {
  $data['node']['redirects'] = [
    'title' => t('Redirects'),
    'group' => t('Content'),
    'field' => [
      'title' => t('Redirects'),
      'help' => t('Redirect from this node.'),
      'id' => 'node_redirects',
    ],
  ];
}
