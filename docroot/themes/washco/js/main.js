(function ($) {
  $(document).ready(function () {

    var body = $("html, body");

    /*Google Translate*/
    $('.goog-te-combo').change(function() {
        var lang = $(this).val();
        if (lang){
          var url = "https://translate.google.com/translate?hl=en&sl=en&u=" + window.location.href + "&tl=" + lang;
          window.location.href = url;
        }
    });

  });
})(jQuery);

