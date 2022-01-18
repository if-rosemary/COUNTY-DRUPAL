/**
 * @file
 * Provide accordion dialog.
 */

(function ($, Drupal, CKEDITOR) {

  'use strict';

  CKEDITOR.dialog.add('accordion', function (editor) {

    return {
      title: 'Insert Accordion',
      minWidth: 510,
      minHeight: 200,
      contents:
        [{
          id: 'accordionPlugin',
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
                  var title = $(element).find('button.accordion-button').text();

                  var dialog = CKEDITOR.dialog.getCurrent();
                  var titleField = dialog.getContentElement('accordionPlugin', 'title').setValue(title);
                }
              },
              {
                type: 'checkbox',
                id: 'collapsed',
                label: 'Collapsed',
                'default': 'checked',
                setup: function (widget) {
                  //grab title and set in dialog.
                  var element = $('<div>').append(widget.element.getHtml());
                  var collapsed = $(element).find('div.accordion-collapse').hasClass('show');
                  var show = collapsed ? false : true;

                  var dialog = CKEDITOR.dialog.getCurrent();
                  var bodyField = dialog.getContentElement('accordionPlugin', 'collapsed').setValue(show);
                }
              },
              {
                id: 'body',
                type: 'textarea',
                className: 'hidden',
                setup: function (widget) {
                  //grab title and set in dialog.
                  var element = widget.element.getHtml();
                  var body = $(element).find('div.accordion-body').html();

                  var dialog = CKEDITOR.dialog.getCurrent();
                  var bodyField = dialog.getContentElement('accordionPlugin', 'body').setValue(body);
                }
              }
            ]
        }
        ],
      onOk: function () {
        var content = '';

        var title = this.getValueOf('accordionPlugin', 'title') || '';
        var body = this.getValueOf('accordionPlugin', 'body') || 'Insert body here...';
        var collapsed = this.getValueOf('accordionPlugin', 'collapsed');

        var buttonStatus = collapsed ? 'aria-expanded="false" class="accordion-button collapsed"' : 'aria-expanded="true" class="accordion-button"';
        var bodyStatus = collapsed ? '' : 'show';

        var collapseID = 'CP' + Date.now();

        content += '<div class="mb-3 accordion-item cke-accordion"><h2 class="accordion-header" id="heading' + collapseID + '"><button aria-controls="' + collapseID + '" ' + buttonStatus + ' data-bs-target="#' + collapseID + '" data-bs-toggle="collapse" type="button">' + title + '</button></h2>';
        content += '<div class="accordion-collapse collapse ' + bodyStatus + '" id="' + collapseID + '">';
        content += '<div class="accordion-body">' + body + '</div>';
        content += '</div>';
        content += '</div>';

        var element = CKEDITOR.dom.element.createFromHtml(content);

        //reset stored values
        body = '';

        editor.insertElement(element);
        editor.widgets.initOn(element, 'accordion_widget');


      },
      buttons: [CKEDITOR.dialog.cancelButton, CKEDITOR.dialog.okButton]
    };
  });

})(jQuery, Drupal, CKEDITOR);
