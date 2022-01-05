/**
 * @file
 * Provide card dialog.
 */

(function ($, Drupal, CKEDITOR) {

  'use strict';

  CKEDITOR.dialog.add('card', function (editor) {

    return {
      title: 'Insert Card',
      minWidth: 510,
      minHeight: 200,
      contents:
        [{
          id: 'cardPlugin',
          expand: true,
          elements:
            [
              {
                id: 'title',
                type: 'text',
                width: '100%',
                label: "Title: ",
                setup: function (widget) {
                  //grab title and set in dialog.
                  var element = $('<div>').append(widget.element.getHtml());
                  var title = $(element).find('div.card-header').text();

                  var dialog = CKEDITOR.dialog.getCurrent();
                  var titleField = dialog.getContentElement('cardPlugin', 'title').setValue(title);
                }
              },
              {
                id: 'body',
                type: 'textarea',
                className: 'hidden',
                setup: function (widget) {
                  //grab title and set in dialog.
                  var element = $('<div>').append(widget.element.getHtml());
                  var body = $(element).find('div.card-body').html();

                  var dialog = CKEDITOR.dialog.getCurrent();
                  var bodyField = dialog.getContentElement('cardPlugin', 'body').setValue(body);
                }
              }
            ]
        }
        ],
      onOk: function () {
        var content = '';

        var title = this.getValueOf('cardPlugin', 'title') || '';
        var bodySample = '<p class="card-text">Insert body here...</p><p><a href="#" class="btn btn-primary">Go somewhere</a></p>';
        var body = this.getValueOf('cardPlugin', 'body') || bodySample;

        content += '<div class="card cke-card">';
        content += '<div class="card-header"><strong>' + title + '</strong></div>';
        content += '<div class="card-body">';
        content += body;
        content += '</div>';

        var element = CKEDITOR.dom.element.createFromHtml(content);

        //reset stored values
        body = '';

        editor.insertElement(element);
        editor.widgets.initOn(element, 'card_widget');


      },
      buttons: [CKEDITOR.dialog.cancelButton, CKEDITOR.dialog.okButton]
    };
  });

})(jQuery, Drupal, CKEDITOR);
