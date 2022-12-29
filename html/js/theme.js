(function ($) {
  var current = location.pathname.split("/");
  $("#myTogglerNav a.nav-link").each(function () {
    var $this = $(this);
    // if the current path is like this link, make it active
    var href = $this.attr("href").split("/");
    if (href[1] == current[1]) {
      $this.addClass("active");
    }
  });
})(jQuery);