/**
 * @file Global helper JS for the theme.
 */

// Import site-wide libraries.
import './_bootstrap.js';
import './_header.js';

(function ($, Drupal) {

  'use strict';

  // // Enable Bootstrap Popover sitewide.
  // // Popovers are opt-in for performance reasons.
  // Drupal.behaviors.bsPopover = {
  //   attach: function (context) {
  //     $('[data-bs-toggle="popover"]').popover();
  //   }
  // };

  // // Controls sitewide alert banner function.
  Drupal.behaviors.alertSystem = {
    attach: function (context) {
      var alertData = {};

      try {
        alertData = JSON.parse(localStorage.getItem('alertUID')) || {};
      }
      catch (e) {
        console.log(e);
      }

      $.each(alertData, function (index, value) {
        $('#' + index).remove();
      });

      $(".alert-item .btn-close").click(function (e) {
        var alertUID = $(this).attr('data-alert');
        alertData[alertUID] = 1;
        try {
          localStorage.setItem('alertUID', JSON.stringify(alertData));
        }
        catch (e) {
          return false;
        }
      });

      $('.alert-group').removeClass('hidden');
    }
  };

  // // Enable Bootstrap Toast sitewide.
  // // Toasts are opt-in for performance reasons.
  // Drupal.behaviors.bsToast = {
  //   attach: function (context) {
  //     $('.toast').toast('show');
  //   }
  // };



})(jQuery, Drupal);
