/**
 * @file Scripting for site-wide headers.
 */

(function ($, Drupal) {
  "use strict";

  /***
   * Position main header-navigation fly-outs.
   *
   * The header main-navigation has flyout generated by Bootstrap and the
   * Radix theme. These are positioned (once opened) absolutely, below the
   * parent menu item. We'd instead like to show them directly below the
   * horizontal stripe of the header.
   *
   * Since relative styling would require un-setting the position of many parent
   * containers we calculate the container height and set a new "top"
   * position.
   */
  Drupal.behaviors.westyHeaderPosition = {
    attach: function (context) {
      const container = document.querySelector(".page__main_header nav.navbar");
      const navLinks = container.querySelectorAll(".nav-item");

      [].forEach.call(navLinks, function (link, index) {
        // Add classes for fitting drop-downs.
        if (index > 0) {
          let menu = link.querySelector(".dropdown-menu");
          if (menu) {
            menu.classList.add("dropdown-menu-end");
          }
        }
        // Add offset for fitting drop-downs.
        link.addEventListener("show.bs.dropdown", function () {
          let menu = this.querySelector(".dropdown-menu");
          if (menu) {
            menu.style.top = container.offsetHeight - this.offsetHeight + "px";
          }
        });
      });
    },
  };

  /***
   * Position navigation search box.
   */
  Drupal.behaviors.westyHeaderSearch = {
    attach: function (context) {
      const container = document.querySelector(".page__main_header nav.navbar");
      const searchLink = container.querySelector("[href='/search']");
      if (searchLink) {
        const searchBox = container.querySelector("#search-block-form");
        const menu = searchLink.parentNode.querySelector(".dropdown-menu");
        if (menu && searchBox) {
          searchLink.parentNode.replaceChild(searchBox, menu);
        }
      }
    },
  };
})(jQuery, Drupal);
