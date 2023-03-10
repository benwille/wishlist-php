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
(function ($) {
  $('.home input[type=checkbox]').change(function () {
    console.log($(this).prop('checked'));
    var purchased;
    if ($(this).prop('checked') === true) {
      purchased = 1;
    } else {
      purchased = 0;
    }
    $.post("wishlist/ajax.php", {
      item: {
        id: $(this).val(),
        purchased: purchased
      }
    }).done(function (data) {
      console.log(data);
      $('#accordion').before("<div id='message'>" + data + "</div>");
      // location.reload();
    });
  });
})(jQuery);