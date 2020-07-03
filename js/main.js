;(function () {

    'use strict';

    var getTestimonials = function (){

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'API/general/testimonials_list.php',
            data: 'EvolveMaster',
            cache: false,
            success: function (data) {
               console.log(data);
            },
            error: function (data) {
               console.log('error', data);
            }
        });
    }

    var numberWithSpaces = function (_Number) {
        return _Number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    var emailPopup = function (_ValuesLoan, _ValuesMonths) {
        var new_btn = 'btn-green';
        var newTitle = '';
        var phpContent = 'url:modules/email/templates/popup_email.php?ValuesLoan=' + numberWithSpaces(_ValuesLoan) + '&ValuesMonths=' + _ValuesMonths;
        var art_name;

        $.confirm({
            boxWidth: '80%',
            useBootstrap: false,
            title: newTitle,
            content: phpContent,
            buttons: {
                formSubmit: {
                    text: 'Pošalji',
                    btnClass: new_btn,
                    action: function () {
                        var clientName = $('#client-name').val();
                        var clientPhone = $('#client-phone').val();
                        var clientNote = $('#client-note').val();
                        var clientWeb = $('#client-web').val();
                        var $form = $('#send_email_form');

                        if (!clientPhone) {
                            $.alert('Molimo upišite kontakt telefon');
                            $("#client-phone").addClass('required');
                            return false;
                        }

                        var data = {
                            clientNote: clientNote
                        };
                        data = $form.serialize() + '&' + $.param(data);

                        console.log(clientWeb);
                        if (!!!clientWeb) {

                            $.ajax({
                                type: 'POST',
                                // dataType: "json",
                                url: 'modules/email/actions/send_email.php',
                                data: data,
                                cache: false,
                                success: function (response) {
                                    $.alert({
                                        title: 'Hvala na upitu!',
                                        content: 'Kontaktirat ćemo vas u najkraćem roku!',
                                    });

                                },
                                error: function (data) {
                                }
                            }); //AJAX*///
                        }

                    } //CONFIRM ACTTION
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {

            }
        }); //CONFIRM
    };
    // ion.rangeSlider
    var ionRangeSlider = function () {

        const valuesLoan = [5000, 10000, 20000, 40000, 60000, 80000, 100000, 200000];
        const valuesMonths = [36, 42, 48, 54, 60];

        let valuesLoantoForm = valuesLoan[0];
        let valuesMonthstoForm = valuesMonths[0];

        const $totalLoan = $(".js-loan");
        const $totalMonths = $(".js-months");
        const $continueButton = $("#action-continue-button");
        const $continueButtonWrapper = $("#action-continue-button-wrapper");
        const $wrapperMonths = $("#wrapper-months");

        $totalLoan.text(numberWithSpaces(valuesLoan[0]) + ' kn');
        $totalMonths.text(valuesMonths[0] + ' mjeseci');

        $(".js-range-slider-total-credit").ionRangeSlider({
            skin: "big",
            grid: false,
            postfix: ' kn',
            hide_min_max: true,
            values: valuesLoan,
            extra_classes: 'action-slider',
            onChange: function (data) {
                $totalLoan.text(numberWithSpaces(data.from_value) + ' kn');
                valuesLoantoForm = data.from_value;
            },
            onFinish: function (data) {
                $continueButtonWrapper.delay(500).fadeIn();
            },

        });

        $(".js-range-slider-total-months").ionRangeSlider({
            skin: "big",
            grid: false,
            hide_min_max: true,
            values: valuesMonths,
            extra_classes: 'action-slider',
            onChange: function (data) {
                $totalMonths.text(data.from_value + ' mjeseci');
                valuesMonthstoForm = data.from_value;
            },
            onFinish: function (data) {
                $continueButtonWrapper.delay(500).fadeIn();
            },

        });

        let countStep = 2;
        $continueButton.on("click", function () {
            if (countStep === 2) {
                $wrapperMonths.fadeIn();
                $("#action-continue-button").text('Zatraži kontakt');
            } else {
                emailPopup(valuesLoantoForm, valuesMonthstoForm);
            }
            countStep++;
        });

    };

    // iPad and iPod detection
    var isiPad = function () {
        return (navigator.platform.indexOf("iPad") != -1);
    };

    var isiPhone = function () {
        return (
            (navigator.platform.indexOf("iPhone") != -1) ||
            (navigator.platform.indexOf("iPod") != -1)
        );
    };

    // Parallax
    var parallax = function () {
        $(window).stellar();
    };

    // Burger Menu
    var burgerMenu = function () {

        $('body').on('click', '.js-fh5co-nav-toggle', function (event) {

            event.preventDefault();

            if ($('#navbar').is(':visible')) {
                $(this).removeClass('active');
            } else {
                $(this).addClass('active');
            }

        });

    };

    var goToTop = function () {

        $('.js-gotop').on('click', function (event) {

            event.preventDefault();

            $('html, body').animate({
                scrollTop: $('html').offset().top
            }, 500);

            return false;
        });

    };

    // Page Nav
    var clickMenu = function () {

        $('#navbar a:not([class="external"])').click(function (event) {
            var section = $(this).data('nav-section'),
                navbar = $('#navbar');

            if ($('[data-section="' + section + '"]').length) {
                $('html, body').animate({
                    scrollTop: $('[data-section="' + section + '"]').offset().top
                }, 500);
            }

            if (navbar.is(':visible')) {
                navbar.removeClass('in');
                navbar.attr('aria-expanded', 'false');
                $('.js-fh5co-nav-toggle').removeClass('active');
            }

            event.preventDefault();
            return false;
        });

    };

    // Reflect scrolling in navigation
    var navActive = function (section) {

        var $el = $('#navbar > ul');
        $el.find('li').removeClass('active');
        $el.each(function () {
            $(this).find('a[data-nav-section="' + section + '"]').closest('li').addClass('active');
        });

    };

    var navigationSection = function () {

        var $section = $('section[data-section]');

        $section.waypoint(function (direction) {

            if (direction === 'down') {
                navActive($(this.element).data('section'));
            }
        }, {
            offset: '150px'
        });

        $section.waypoint(function (direction) {
            if (direction === 'up') {
                navActive($(this.element).data('section'));
            }
        }, {
            offset: function () {
                return -$(this.element).height() + 155;
            }
        });

    };

    // Window Scroll
    var windowScroll = function () {
        var lastScrollTop = 0;

        $(window).scroll(function (event) {

            var header = $('#fh5co-header'),
                scrlTop = $(this).scrollTop();

            if (scrlTop > 500 && scrlTop <= 2000) {
                header.addClass('navbar-fixed-top fh5co-animated slideInDown');
            } else if (scrlTop <= 500) {
                if (header.hasClass('navbar-fixed-top')) {
                    header.addClass('navbar-fixed-top fh5co-animated slideOutUp');
                    setTimeout(function () {
                        header.removeClass('navbar-fixed-top fh5co-animated slideInDown slideOutUp');
                    }, 100);
                }
            }

        });
    };

    // Animations
    // Home

    var homeAnimate = function () {
        if ($('#fh5co-home').length > 0) {

            $('#fh5co-home').waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    setTimeout(function () {
                        $('#fh5co-home .to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var introAnimate = function () {
        if ($('#fh5co-intro').length > 0) {

            $('#fh5co-intro').waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    setTimeout(function () {
                        $('#fh5co-intro .to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInRight animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 1000);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var workAnimate = function () {
        if ($('#fh5co-work').length > 0) {

            $('#fh5co-work').waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    setTimeout(function () {
                        $('#fh5co-work .to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var testimonialAnimate = function () {
        var testimonial = $('#fh5co-testimonials');
        if (testimonial.length > 0) {

            testimonial.waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    var sec = testimonial.find('.to-animate').length,
                        sec = parseInt((sec * 200) - 400);

                    setTimeout(function () {
                        testimonial.find('.to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    setTimeout(function () {
                        testimonial.find('.to-animate-2').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInDown animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, sec);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var servicesAnimate = function () {
        var services = $('#fh5co-services');
        if (services.length > 0) {

            services.waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    var sec = services.find('.to-animate').length,
                        sec = parseInt((sec * 200) + 400);

                    setTimeout(function () {
                        services.find('.to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    setTimeout(function () {
                        services.find('.to-animate-2').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('bounceIn animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, sec);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var aboutAnimate = function () {
        var about = $('#fh5co-about');
        if (about.length > 0) {

            about.waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    setTimeout(function () {
                        about.find('.to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var countersAnimate = function () {
        var counters = $('#fh5co-counters');
        if (counters.length > 0) {

            counters.waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    var sec = counters.find('.to-animate').length,
                        sec = parseInt((sec * 200) + 400);

                    setTimeout(function () {
                        counters.find('.to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    setTimeout(function () {
                        counters.find('.js-counter').countTo({
                            formatter: function (value, options) {
                                return value.toFixed(options.decimals);
                            },
                        });
                    }, 400);

                    setTimeout(function () {
                        counters.find('.to-animate-2').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('bounceIn animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, sec);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    var contactAnimate = function () {
        var contact = $('#fh5co-contact');
        if (contact.length > 0) {

            contact.waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('animated')) {

                    setTimeout(function () {
                        contact.find('.to-animate').each(function (k) {
                            var el = $(this);

                            setTimeout(function () {
                                el.addClass('fadeInUp animated');
                            }, k * 200, 'easeInOutExpo');

                        });
                    }, 200);

                    $(this.element).addClass('animated');

                }
            }, {offset: '80%'});

        }
    };

    // Document on load.
    $(function () {

        getTestimonials();

        ionRangeSlider();

        parallax();

        burgerMenu();

        clickMenu();

        windowScroll();

        navigationSection();

        goToTop();

        // Animations
        homeAnimate();
        introAnimate();
        workAnimate();
        testimonialAnimate();
        servicesAnimate();
        aboutAnimate();
        countersAnimate();
        contactAnimate();

    });

}());
