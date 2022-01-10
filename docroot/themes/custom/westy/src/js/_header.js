/**
 * @file Scripting for site-wide headers.
 */

(function (Drupal) {
  "use strict";

  /***
   * Position main header-navigation fly-outs.
   *
   * The header main-navigation has drop-downs implemented with Bootstrap and
   * the Radix theme. These are positioned (once opened) absolutely, below the
   * parent menu item. We'd instead like to show below the horizontal stripe
   * of the header.
   *
   * Since relative styling would require un-setting position on many parent
   * items we calculate the container height and set a new "top"
   * position.
   */
  Drupal.behaviors.westyHeaderPosition = {
    attach: function (context) {
      const container = document.querySelector(".page__header");
      const navLinks = container.querySelectorAll(".nav-item");

      [].forEach.call(navLinks, function (link, index) {
        // Add classes for fitting drop-downs.
        if (index > 0) {
          let menu = link.querySelector(".dropdown-menu");
          if (menu) {
            menu.classList.add("dropdown-menu-end");
          }
        }
        // Add offset for positioning drop-downs.
        link.addEventListener("show.bs.dropdown", function () {
          let menu = this.querySelector(".dropdown-menu");
          if (menu) {
            menu.style.top =
              container.offsetHeight -
              this.offsetHeight -
              this.paddingTop -
              this.paddingBottom +
              "px";
          }
        });
        // Give the search form focus.
        link.addEventListener("shown.bs.dropdown", function () {
          let searchInput = this.querySelector(
            ".dropdown-menu input[name='search']"
          );
          if (searchInput) {
            searchInput.focus();
          }
        });
      });
    },
  };

  /***
   * Position navigation search box.
   *
   * The header navigation has a search form appear after clicking "Search".
   * Rather than recreate the header template file, we add the search form
   * to the page HTML and move it under the menu item.
   */
  Drupal.behaviors.westyHeaderSearch = {
    attach: function (context) {
      const container = document.querySelector(".page__header");
      const searchLink = container.querySelector("[href='/search']");
      if (searchLink) {
        const searchBox = container.querySelector("#search-block-form");
        const dropdown = searchLink.parentNode.querySelector(".dropdown-menu");
        if (dropdown && searchBox) {
          searchLink.parentNode.replaceChild(searchBox, dropdown);
        }
      }
    },
  };
})(Drupal);
