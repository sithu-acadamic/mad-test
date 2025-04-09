$(document).ready(function () {
  $('.captureToolTip').tooltipster({
    theme: 'tooltipster-borderless',
    side: ['top','bottom','right','left',],
    contentCloning: false,
    trigger: 'custom',
    triggerOpen: {
        click: true,
        tap: true,
        mouseenter: false,
        touchstart: false,
    },
    triggerClose: {
      mouseleave: true,
      originClick: true,
      touchleave: true
    }
  });

  $('#loginform').validate({
    rules: {
      captcha_text: {
        required: true,
        rangelength: [4, 4],
        number: true
      }
    },
    messages: {
      captcha_text: {
        required: "Please enter Image Text.",
        rangelength: "Image Text must be 4 characters.",
        number: "Image Text should be a number."
      }
    }
  });
    $('form input[type=text]').focus(function(){
        $(this).siblings(".capture-error").hide();
    });
});

$('#regen-captcha').on('click', function(e){
  e.preventDefault();
  refreshCaptcha();
});

function refreshCaptcha() {
  var captcha = $('#regen-captcha').prev('img');
  $.ajax({
    type: "GET",
    url: '/ajax-regen-captcha',
  }).done(function( msg ) {
    captcha.attr('src', msg);
  });
}

