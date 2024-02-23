
require([
  'jquery',
  'jquery/ui'
], function(
  $,
  ui
) {
  
  /**
   * Mopbile page footer
   */
  $(window).ready(function() {
    if ($(window).width() < 769) {
      $(".custom-footer .collapsible .title").click(function() {
        $(this).parent().toggleClass("open");
      });
    }
  });
});
