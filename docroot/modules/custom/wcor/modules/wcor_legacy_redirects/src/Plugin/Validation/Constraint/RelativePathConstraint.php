<?php

namespace Drupal\wcor_legacy_redirects\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Path is relative, no illegal path chars, and doesn't exist in form or system.
 *
 * @Constraint(
 *   id = "relative_path",
 *   label = @Translation("Verifies path is relative.", context = "Validation"),
 *   type = "string"
 * )
 */
class RelativePathConstraint extends Constraint {

  /**
   * Not a relative path.
   *
   * @var string*/
  public $notRelative = "The legacy path must be relative (i.e. no protocol or domain) and start with a slash.";

  /**
   * Illegal characters.
   *
   * @var string*/
  public $illegalChars = "The legacy path contains invalid characters. It should only contain letters, numbers, and the following symbols: slash (/), dot (.), hyphen (-), and underscore (_)";

  /**
   * Duplicate in form.
   *
   * @var string*/
  public $duplicateInForm = "A legacy path may only be entered once. Please remove the duplicate path.";

  /**
   * Duplicate redirect.
   *
   * @var string*/
  public $duplicateRedirect = "This legacy path already redirects to a content node in the system. A path cannot redirect to multiple nodes.";

}
