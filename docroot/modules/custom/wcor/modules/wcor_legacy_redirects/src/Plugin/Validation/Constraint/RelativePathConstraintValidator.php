<?php

namespace Drupal\wcor_legacy_redirects\Plugin\Validation\Constraint;

use Drupal\Core\Field\FieldItemListInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the PreventAnon constraint.
 */
class RelativePathConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($field, Constraint $constraint) {

    // Is it single value or FieldItemList?
    if ($field instanceof FieldItemListInterface && $field->getName() == "field_redirects") {
      foreach ($field as $delta => $value) {
        $path = $value->value;

        $entity = $field->getEntity();
        // $original = $entity->original;
        // Test if path is bare (no protocol)
        if (!$this->validateRelative($path)) {
          // Remove protocol from path for suggestion in validation message.
          $relative_path = parse_url($path, PHP_URL_PATH);
          $message = $constraint->notRelative . " Try using \"$relative_path\" instead.";
          $this->setViolation($message, $delta);
        }

        // Test if path starts with slash.
        if (!$this->validateStartsWithSlash($path)) {
          $message = $constraint->notRelative;
          $this->setViolation($message, $delta);
        }

        // Test if any illegal characters.
        if (!$this->validateValidChars($path)) {
          $message = $constraint->illegalChars;
          $this->setViolation($message, $delta);
        }

        // Test if this path already exists.
        if (!$this->validateUniquePathInForm($path, $delta, $field)) {
          $message = $constraint->duplicateInForm;
          $this->setViolation($message, $delta);
        }

        // Test if this path already exists. This function returns either
        // true if valid, or path to the other duplicate so it can be included
        // in the error message. If validation works, there should only be
        // one value returned in the array on failure.
        // $group_id = $entity->get('field_group')->getValue()[0]['target_id'];
        $eid = $entity->Id();
        $type = $entity->getEntityTypeId();

        $is_unique_in_system = $this->validateUniquePathInSystem($path, $type, $eid);
        if ($is_unique_in_system !== TRUE && !is_null($is_unique_in_system)) {
          $keys = array_keys($is_unique_in_system);
          $duplicate = $is_unique_in_system[$keys[0]];
          $dup_path = "/" . $duplicate->get('redirect_source')->getValue()[0]['path'];

          $path_link_message = "";
          if (is_array($is_unique_in_system) && count($is_unique_in_system) > 0) {
            $path_link_message = " (<a href=\"$dup_path\" target=\"_blank\">$dup_path</a>)";
          }
          $message = "The legacy path already exists in the system$path_link_message. A path cannot redirect to multiple pages.";
          ;
          $this->setViolation($message, $delta);
        }

      }
    }
  }

  /**
   * Correct field in the multiple-value widget is targeted.
   */
  public function setViolation($message, $delta) {
    $this->context->buildViolation($message)
      ->atPath((string) $delta)
      ->addViolation();
  }

  /**
   * Validate relative path.
   */
  public function validateRelative($path) {
    // don't want to see http/https at start of path.
    return !preg_match('/^(?:http|https):\/\/.+$/', $path);
  }

  /**
   * Validate that path starts with slash.
   */
  public function validateStartsWithSlash($path) {
    // Want to see slash at start of path.
    return preg_match('/^\/.+/', $path);
  }

  /**
   * Validate that all characters are valid.
   */
  public function validateValidChars($path) {
    // Only want to see these characters in path.
    return !preg_match('/[^\/\w.-]/', $path);
  }

  /**
   * Validate no repeated paths in form.
   */
  public function validateUniquePathInForm($path, $delta, $field) {
    // Verify path is unique within all the deltas of the field.
    // If not, both dupe fields will highlight with validation errors.
    foreach ($field as $delta2 => $value) {
      $path2 = $value->value;
      if ($delta == $delta2) {
        continue;
      }
      if ($path == $path2) {
        return FALSE;
      }
    }
    return TRUE;
  }

  /**
   * Validate path doesn't already exist.
   */
  public function validateUniquePathInSystem($path, $type, $eid) {
    // all: valid if no source path matches found.
    // new page (no $eid): invalid if any source path matches found.
    // existing page: invalid if source path and redirect uri don't match.
    // Strip leading slash from path.
    $path = substr($path, 0, 1) == "/" ? substr($path, 1) : $path;

    // 2 possible URI formats the redirect might use; need to test for both.
    $uri1 = "entity:$type/$eid";
    $uri2 = "internal:/$type/$eid";

    // Get redirects with matching source.
    $matches = \Drupal::service('redirect.repository')->findBySourcePath($path);
    $invalid = [];

    // Return true immediately if no matches found; yay, valid!
    if (!$matches || count($matches) < 1) {
      return TRUE;
    }

    // Spin through matches...
    // if $eid is null (new page), then any matches are invalid.
    if (!$eid && count($matches)) {
      return $matches;
    }

    // $eid is not null; if redirect uri matches current, it's valid
    foreach ($matches as $key => $redirect) {
      $existing_uri = $redirect->get('redirect_redirect')->getValue()[0]['uri'];
      if ($existing_uri != $uri1 && $existing_uri != $uri2) {
        $invalid[] = $redirect;
      }
    }
    unset($key);
    return count($invalid) > 0 ? $invalid : TRUE;
  }

}
