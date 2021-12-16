/*
* CKEditor Accordion Plugin
*
* @author Washington County Webteam <webteam@co.washington.or.us>
* @version 1.0.0
*/
(function ($, Drupal) {
	CKEDITOR.plugins.add('accordion', {
		init: function (editor) {
      CKEDITOR.dialog.add('accordion', CKEDITOR.getUrl(this.path + 'dialogs/accordion.js'));
			editor.addCommand('accordion', new CKEDITOR.dialogCommand('accordion', {
				allowedContent: 'div{*}(*); a[*]; img[*]'
      }));
      editor.addContentsCss(this.path + 'styles/widget.css');

      editor.widgets.add('accordion_widget', {
        upcast: function (element) {
          return element.name === 'div' && element.hasClass('cke-accordion');
        },
        // List editable areas here.
        editables: {
          body: {
            selector: '.accordion-body'
          }
        },
        requiredContent: 'div(cke-accordion)',
        allowedContent: 'img',
        dialog: 'accordion'
      });

			editor.ui.addButton('Accordion', {
				label : 'Insert Accordion',
				toolbar : 'insert',
				command : 'accordion',
				icon : this.path + 'images/icon.png'
			});


		}
	});

})(jQuery, Drupal);
