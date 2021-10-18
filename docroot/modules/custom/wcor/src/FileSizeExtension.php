<?php

namespace Drupal\wcor;

/**
 * Extends Twig functionality via wcor.
 */
class FileSizeExtension extends \Twig_Extension {

  /**
   * Let Drupal know the name of your extension must be unique name, string.
   */
  public function getName() {
    return 'wcor.filesizeextension';
  }

  /**
   * In this function we can declare the extension function.
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('fileSizeString', [$this, 'fileSizeString'], ['is_safe' => ['html']]),
    ];
  }

  /**
   * Convert to readable file size.
   */
  public function fileSizeString($bytes) {
    if (empty($bytes)) {
      return '';
    }
    $bytes = intval($bytes['#markup']);
    $kbytes = round($bytes / 1024, 2);
    $mbytes = round($kbytes / 1024, 2);
    $size = "";
    if ($mbytes > 1) {
      $size = $mbytes . ' MB';
    }
    elseif ($kbytes > 1) {
      $size = $kbytes . ' KB';
    }
    else {
      $size = $bytes . ' bytes';
    }
    $size = '(' . $size . ')';
    if ($bytes) {
      return $size;
    }
    else {
      return '';
    }
  }

}
