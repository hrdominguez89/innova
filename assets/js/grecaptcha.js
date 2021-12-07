grecaptcha.ready(function() {
    let siteKey = $('#g-recaptcha').data('siteKey');
    let actionRecaptcha = $('#g-recaptcha').data('action')
    grecaptcha.execute(siteKey, {action: actionRecaptcha}).then(function(token) {
        $('#g-recaptcha').val(token);
    });
});