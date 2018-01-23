$("#login_submit").click(function (e) {
  ajax_update ("&nbsp;");
  e.preventDefault();
  if ($("#user_name").val()=="" || $("#password").val()=="") {
    show_error ('Both user name and password are required');
  } else {
    try_ajax ("action=login&user_name=" + encodeURIComponent($("#user_name").val()) + '&password=' + encodeURIComponent($("#password").val()));
  }
});

$(".logout_button").click(function () {
    try_ajax("action=logout");
});

function ajax_update (msg) {
  $("#ajax_update").html(msg);
}

function try_ajax (payload) {
  $.ajax({
    url: "ajax.php",
    type: "POST",
    data: payload,
    dataType: "JSON",
    error: function(xhr, ajax_options, thrown_error) {
      show_error(thrown_error);
    },
    success: function(d) {
      if (!d.logged_in) {
        $("#content").hide();
        $("#login_box").show();
      }
      if (d.error) {
        show_error(d.error);
      } else {
        if (d.logged_out) {
          $("#content").hide();
          $("#login_box").show();
        } else if (d.content_html) {
          if ($("#login_box").is(":visible")) {
            $("#login_box").hide();
            $("#user_name").val("");
            $("#password").val("");
          }
          $("#content_add").html(d.content_html);
          $("#content").css("display", "block");
        }
      }
    }
  });
}

function show_error(err_str) {
  ajax_update ('<div class="error">' + err_str + "</div>");
}

function show_confirmation (conf_str) {
  ajax_update ('<div class="confirmation">' + conf_str + "</div>");
}
