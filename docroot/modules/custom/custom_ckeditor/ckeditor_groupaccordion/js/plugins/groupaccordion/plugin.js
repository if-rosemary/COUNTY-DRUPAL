/*
* CKEditor Groupaccordion Plugin
*
* @author Washington County Webteam <webteam@co.washington.or.us>
* @version 1.0.0
*/
(function ($, Drupal) {
	CKEDITOR.plugins.add('groupaccordion', {
		init: function (editor) {


			editor.addCommand('groupaccordion', new CKEDITOR.dialogCommand('groupaccordion', {
        exec: function (editor) {
          var now = new Date();

          var content = '';
          var collapseID = 'CP' + Date.now();
          var collapseID2 = 'CP' + Date.now() + 1;
          content += '<div class="accordion cke-accordiongroup">'
          content += '<div class="mb-3 accordion-item cke-accordion"><h2 class="accordion-header" id="heading' + collapseID + '"><button aria-controls="' + collapseID + '" class="accordion-button collapsed" data-bs-target="#' + collapseID + '" data-bs-toggle="collapse" type="button">Sample Title</button></h2>';
          content += '<div class="accordion-collapse collapse" id="' + collapseID + '">';
          content += '<div class="accordion-body">Insert body here...</div>';
          content += '</div>';
          content += '</div>';
          content += '<div class="mb-3 accordion-item cke-accordion"><h2 class="accordion-header" id="heading' + collapseID2 + '"><button aria-controls="' + collapseID2 + '" class="accordion-button collapsed" data-bs-target="#' + collapseID2 + '" data-bs-toggle="collapse" type="button">Sample Title</button></h2>';
          content += '<div class="accordion-collapse collapse" id="' + collapseID2 + '">';
          content += '<div class="accordion-body">Insert body here...</div>';
          content += '</div>';
          content += '</div>';
          content += '</div>';

          editor.insertHtml(content);
        },
				allowedContent: 'div{*}(*); a[*]; img[*]'
      }));
      editor.addContentsCss(this.path + 'styles/widget.css');

      editor.widgets.add('groupaccordion_widget', {
        upcast: function (element) {
          return element.name === 'div' && element.hasClass('cke-accordiongroup');
        },
        // List editable areas here.
        editables: {
          body: {
            selector: '.cke-accordiongroup'
          }
        },
        requiredContent: 'div(cke-accordiongroup)',
        allowedContent: 'img'
      });

			editor.ui.addButton('Groupaccordion', {
				label : 'Insert Group Accordion',
				toolbar : 'insert',
				command : 'groupaccordion',
				icon : this.path + 'images/icon.png'
			});


		}
	});

})(jQuery, Drupal);
