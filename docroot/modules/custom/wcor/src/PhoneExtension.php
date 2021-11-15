<?php

namespace Drupal\wcor;

/**
 * Extends Twig functionality via wcor.
 */
class PhoneExtension extends \Twig_Extension {

  /**
   * Let Drupal know the name of your extension must be unique name, string.
   */
  public function getName() {
    return 'wcor.phoneextension';
  }

  /**
   * In this function we can declare the extension function.
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('phoneString', [$this, 'phoneString'], ['is_safe' => ['html']]),
    ];
  }

  /**
   * Convert to readable file size.
   */
  public function phoneString($phone, $phoneext = NULL) {
    if (empty($phone)) {
      return '';
    }
    $phoneurl = $phone;
    if ($phoneext) {
      $phoneurl = $phone . ',,' . $phoneext;
      $phoneext = ' x' . $phoneext;
    }
    $phonelink = '<a href="tel:' . $phoneurl . '">' . $phone . $phoneext . '</a>';
    return $phonelink;
  }

}
