$(() => {
	$(document).on('change', '.error', function() {
        $(this).removeClass('error');
    })

    $('form button').on('click', function(event){

        event.preventDefault();
        var dataForAjax = "action=form&";
        var addressForAjax = "/wp-admin/admin-ajax.php";
        var valid = true;

        
        $(this).closest('form').find('input:not([type=submit]),textarea').each(function(i, elem) {
            if (this.value.length < 3 && $(this).hasClass('required')) {
                valid = false;
                $(this).addClass('error');
            }
            if ($(this).attr('name') == 'email' && $(this).hasClass('required')) {
                var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
                if (!pattern.test($(this).val())) {
                    valid = false;
                    $(this).addClass('error');
                }
            }
            if ($(this).attr('name') == 'agree' && !$(this).prop("checked")) {
                $(this).addClass('error');
                valid = false;
            }

            if (i > 0) {
                dataForAjax += '&';
            }
            dataForAjax += this.name + '=' + this.value;
        })

        if (!valid) {
            return false;
        }               

        $.ajax({
            type: 'POST',
            data: dataForAjax,
            url: addressForAjax,
            success: function(response) {
                $.fancybox.close()
				$.fancybox.open({
					src: '#success_modal',
					type: 'inline',
					touch: false,
					// afterShow: (instance, current) => {
					// 	setTimeout(() => { $.fancybox.close() }, 3000)
					// }
				})      				
            	$('.form').trigger("reset");               
            }
        });
      
    });


	// Основной слайдер на главной
	$('.main_slider .slider').owlCarousel({
		items: 1,
		margin: 0,
		nav: false,
		dots: true,
		loop: true,
		smartSpeed: 750,
		autoplay: true,
		autoplayTimeout: 5000,
		onTranslate: (event) => {
			$(event.target).trigger('stop.owl.autoplay')
		},
		onTranslated: (event) => {
			$(event.target).trigger('play.owl.autoplay', [4250, 0])
		}
	})


	// Сертификаты
	$('.certs .slider').owlCarousel({
		nav: true,
		dots: false,
		loop: true,
		smartSpeed: 500,
		responsive: {
			0: {
				items: 1,
				margin: 20
			},
			480: {
				items: 2,
				margin: 20
			},
			768: {
				items: 3,
				margin: 20
			},
			1024: {
				items: 4,
				margin: 20
			},
			1180: {
				items: 4,
				margin: 43
			}
		}
	})
})