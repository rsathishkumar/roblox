
jQuery(document).ready(function($) {
  $('input.elementor-field-custompassword').keyup(function() {
    var pswd = $(this).val();
    if ( pswd.length < 8 ) {
      $('#length').removeClass('valid').addClass('invalid');
    } else {
      $('#length').removeClass('invalid').addClass('valid');
    }

    //validate capital letter
    if ( pswd.match(/[A-Z]/) ) {
      $('#capital').removeClass('invalid').addClass('valid');
    } else {
      $('#capital').removeClass('valid').addClass('invalid');
    }

    //validate number
    if ( pswd.match(/\d/) ) {
      $('#number').removeClass('invalid').addClass('valid');
    } else {
      $('#number').removeClass('valid').addClass('invalid');
    }

  });
  $('input.elementor-field-custompassword').focus(function() {
    $('#pswd_info').show();
    // on Focus
  });
  $('input.elementor-field-custompassword').blur(function() {
    // on Blur
  });

  $(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $('.elementor-field-custompassword');
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  $('select#form-field-field_identification_type').change(function() {
    var options = $('#form-field-field_identification_type option');

    var values = $.map(options ,function(option) {
      $('.elementor-field-group-'+option.value).hide();
    });
    var selected_val = $(this).val();
    $('.elementor-field-group-'+selected_val).show();
  });

});