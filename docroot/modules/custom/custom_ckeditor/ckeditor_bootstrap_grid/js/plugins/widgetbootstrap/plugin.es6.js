/**
 * @file
 * Functionality to enable Bootstrap Grid functionality in CKEditor.
 */

(function () {
  'use strict';

  // Register plugin.
  CKEDITOR.plugins.add('widgetbootstrap', {

    requires: 'widget',
    icons: 'widgetbootstrapLeftCol,widgetbootstrapRightCol,widgetbootstrapTwoCol,widgetbootstrapThreeCol',

    init(editor) {
    // Configurable settings
    // var allowedWidget = editor.config.widgetbootstrap_allowedWidget != undefined ?
    // editor.config.widgetbootstrap_allowedFull :
    //    'p h2 h3 h4 h5 h6 span br ul ol li strong em img[!src,alt,width,height]';

      const showButtons = editor.config.widgetbootstrapShowButtons !== 'undefined' ? editor.config.widgetbootstrapShowButtons : true;

      // Define the widgets
      editor.widgets.add('widgetbootstrapLeftCol', {

        button: showButtons ? 'Add left column box' : 'undefined',
        template:'<div class="row two-col-left">' + '<div class="col-12 col-sm-3 col-md-3 col-sidebar"><p>[Content goes here]</p></div>' + '<div class="col-12 col-sm-9 col-md-9 col-main"><p>[Content goes here]</p></div>' + '</div>',
        editables: {
          col1: {
            selector: '.col-sidebar'
          },
          col2: {
            selector: '.col-main'
          }
        },

        upcast(element) {
          return element.name === 'div' && element.hasClass('two-col-left');
        }

      });

      editor.widgets.add('widgetbootstrapRightCol', {

        button: showButtons ? 'Add right column box' : 'undefined',
        template: '<div class="row two-col-right">' + '<div class="col-12 col-sm-9 col-md-9 col-main"><p>[Content goes here]</p></div>' + '<div class="col-12 col-sm-3 col-md-3 col-sidebar"><p>[Content goes here]</p></div>' + '</div>',
        editables: {
          col1: {
            selector: '.col-sidebar'
          },
          col2: {
            selector: '.col-main'
          }
        },

        upcast(element) {
          return element.name === 'div' && element.hasClass('two-col-right');
        }

      });

      editor.widgets.add('widgetbootstrapTwoCol', {

        button: showButtons ? 'Add two column box' : 'undefined',
        template: '<div class="row two-col">' + '<div class="col-12 col-sm-6 col-md-6 col-first"><p>[Content goes here]</p></div>' + '<div class="col-12 col-sm-6 col-md-6 col-second"><p>[Content goes here]</p></div>' + '</div>',
        editables: {
          col1: {
            selector: '.col-first'
          },
          col2: {
            selector: '.col-second'
          }
        },

        upcast(element) {
          return element.name === 'div' && element.hasClass('two-col');
        }

      });

      editor.widgets.add('widgetbootstrapThreeCol', {

        button: showButtons ? 'Add three column box' : 'undefined',
        template: '<div class="row three-col">' + '<div class="col-12 col-sm-4 col-md-4 col-first"><p>[Content goes here]</p></div>' + '<div class="col-12 col-sm-4 col-md-4 col-second"><p>[Content goes here]</p></div>' + '<div class="col-12 col-sm-4 col-md-4 col-third"><p>[Content goes here]</p></div>' + '</div>',
        editables: {
          col1: {
            selector: '.col-first'
          },
          col2: {
            selector: '.col-second'
          },
          col3: {
            selector: '.col-third'
          }
        },

        upcast(element) {
          return element.name === 'div' && element.hasClass('three-col');
        }

      });
      // Append the widget's styles when in the CKEditor edit page,
      // added for better user experience.
      // Assign or append the widget's styles depending on the existing setup.
      if (typeof editor.config.contentsCss === 'object') {
        editor.config.contentsCss.push(CKEDITOR.getUrl(`${this.path}contents.css`));
      }
      else {
        editor.config.contentsCss = [editor.config.contentsCss, CKEDITOR.getUrl(`${this.path}contents.css`)];
      }
    }


  });
}());
