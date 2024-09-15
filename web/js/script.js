$(() => {
    $('#registerform-password').on('keyup', function (e) {
        const el = $(this),
            val = el.val();
        info = $('.password-info')
        let message = '',
            color = '';
        if (val.length > 5) {
            message = 'Сдабый пароль'
            color = 'text-danger';
            if (val.match('^(?=.*[a-z])(?=.*[A-Z]).+$')) {
                message = 'Средний пароль'
                color = 'text-warning';
                if (val.match('^(?=.*[0-9]).+$')) {
                    message = 'хорший пароль'
                    color = 'text-success';
                    if (val.match('^(?=.*[\!\@\#\$]).+$')) {
                        message = 'отличный пароль'
                        color = 'text-success';
                    }
                }
            }
        } else {
            if (val.length > 3) {
                el.parent('.password-block').find('.feedback-invalid').html('');
                el.removeClass('is-invalid')
                el.addClass('is-valid')

                message = 'СЛабый пароль'
                color = 'text-danger'

            }
        }
        info.removeClass('text-danger')
        info.removeClass('text-warning')
        info.removeClass('text-success');


        info.html(message);
        info.addClass(color);
    })
})