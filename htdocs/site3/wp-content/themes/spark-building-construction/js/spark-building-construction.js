jQuery(document).ready(function($) { 

    /**
     * Add RTL Class in Body
    */
    var brtl = false;
    if ($("body").hasClass('rtl')) { brtl = true; }

    // Remove svg.radial-progress .complete inline styling
    $('svg.radial-progress').each(function( index, value ) { 
        $(this).find($('circle.complete')).removeAttr( 'style' );
    });

    // Activate progress animation on scroll
    $(window).scroll(function(){
        $('svg.radial-progress').each(function( index, value ) { 
            // If svg.radial-progress is approximately 25% vertically into the window when scrolling from the top or the bottom
            if ( 
                $(window).scrollTop() > $(this).offset().top - ($(window).height() * 0.75) &&
                $(window).scrollTop() < $(this).offset().top + $(this).height() - ($(window).height() * 0.25)
            ) {
                // Get percentage of progress
                percent = $(value).data('percentage');
                color = $(value).data('color');
                // Get radius of the svg's circle.complete
                radius = $(this).find($('circle.complete')).attr('r');
                // Get circumference (2πr)
                circumference = 2 * Math.PI * radius;
                // Get stroke-dashoffset value based on the percentage of the circumference
                strokeDashOffset = circumference - ((percent * circumference) / 100);
                // Transition progress for 1.25 seconds
                $(this).find($('circle.complete')).animate({'stroke-dashoffset': strokeDashOffset}, 1250);
                $(this).find($('circle.complete')).css({'stroke': color});
            }
        });
    }).trigger('scroll');
    

    /**
     * Testimonial
     */
     var testOwl = $('.testimonial-slider');
     testOwl.owlCarousel({
        loop: true,
        margin: 10,
        center:true,
        dots: true,
        smartSpeed: 2000,
        autoplay: false,
        autoplayTimeout: 5000,
        nav: false,
        navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
        items: 1,
        rtl: brtl,
        responsive: {
            0: {
                items: 1,
                nav: false,
            },
            600: {
                items: 1,
                nav: false
            },
            1000: {
                items: 1
            }
        }
    });

    $('.cons-testimonial-layout-left .owl-next').click(function() {
        testOwl.trigger('next.owl.carousel');
    })
    
    $('.cons-testimonial-layout-left .owl-prev').click(function() {
        testOwl.trigger('prev.owl.carousel', [300]);
    })
});
