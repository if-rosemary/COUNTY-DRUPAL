/*
* CKEditor Card Plugin
*
* @author Washington County Webteam <webteam@co.washington.or.us>
* @version 1.0.0
*/
(function ($, Drupal) {
	CKEDITOR.plugins.add('card', {
		init: function (editor) {
      CKEDITOR.dialog.add('card', CKEDITOR.getUrl(this.path + 'dialogs/card.js'));
			editor.addCommand('card', new CKEDITOR.dialogCommand('card', {
				allowedContent: 'div{*}(*); a[*]; img[*]'
      }));
      editor.addContentsCss(this.path + 'styles/widget.css');

      editor.widgets.add('card_widget', {
        upcast: function (element) {
          return element.name === 'div' && element.hasClass('cke-card');
        },
        // List editable areas here.
        editables: {
          body: {
            selector: '.card-body'
          }
        },
        requiredContent: 'div(cke-card)',
        allowedContent: 'img',
        dialog: 'card'
      });

			editor.ui.addButton('Card', {
				label : 'Insert Card',
				toolbar : 'insert',
				command : 'card',
				icon : this.path + 'images/icon.png'
			});


		}
	});

})(jQuery, Drupal);
