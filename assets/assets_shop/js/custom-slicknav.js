$(document).ready(function() {
    // Preload menu styles and resources
    $('<div/>').addClass('slicknav-preloader').css({
        'position': 'absolute',
        'width': '1px',
        'height': '1px',
        'overflow': 'hidden',
        'opacity': '0'
    }).appendTo('body');

    // Initialize slicknav with enhanced options
    $('.mainmenu').slicknav({
        prependTo: '#header-bottom .container',
        label: '',
        allowParentLinks: true,
        closedSymbol: '<i class="fa fa-angle-right"></i>',
        openedSymbol: '<i class="fa fa-angle-down"></i>',
        beforeOpen: function(trigger) {
            // Add opening animation
            $(trigger).addClass('animated');
        },
        beforeClose: function(trigger) {
            // Add closing animation
            $(trigger).addClass('animated');
        }
    });

    // Force hardware acceleration for smoother animations
    $('.slicknav_nav, .slicknav_nav *, .slicknav_btn').css({
        'transform': 'translateZ(0)',
        'backface-visibility': 'hidden'
    });

    // Add icons to menu items if needed
    $('.slicknav_nav > li > a').each(function() {
        const menuText = $(this).text().trim();
        
        // Add icons based on menu text
        if (menuText.includes('Barang')) {
            $(this).html('<i class="fa fa-cubes"></i> ' + menuText);
        } else if (menuText.includes('Transaksi')) {
            $(this).html('<i class="fa fa-exchange"></i> ' + menuText);
        } else if (menuText.includes('Ganti Password')) {
            $(this).html('<i class="fa fa-key"></i> ' + menuText);
        } else if (menuText.includes('Register')) {
            $(this).html('<i class="fa fa-user-plus"></i> ' + menuText);
        } else if (menuText.includes('Login')) {
            $(this).html('<i class="fa fa-sign-in"></i> ' + menuText);
        } else if (menuText.includes('LOGOUT')) {
            $(this).html('<i class="fa fa-sign-out"></i> ' + menuText);
        } else if (menuText.includes('Halo')) {
            $(this).html('<i class="fa fa-user"></i> ' + menuText);
        }
    });

    // Enhance mobile hover detection - touch events
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('.slicknav_nav a, .slicknav_nav .slicknav_row').on('touchstart', function() {
            // First remove any active hover state
            $('.slicknav_nav a, .slicknav_nav .slicknav_row').removeClass('hover-active');
            // Then add it to the current element
            $(this).addClass('hover-active');
        });
    }
    
    // Make sure menu items have proper hover state without delay
    $('.slicknav_nav a, .slicknav_nav .slicknav_row').hover(
        function() {
            $(this).addClass('hover-active');
        },
        function() {
            $(this).removeClass('hover-active');
        }
    );

    // Enhance slicknav menu with animations and active class
    $('.slicknav_btn').on('click', function() {
        $(this).toggleClass('slicknav_open');
        
        // Add animation to menu items
        if($(this).hasClass('slicknav_open')) {
            $('.slicknav_nav').removeClass('slicknav_hidden');
            $('.slicknav_nav').css('opacity', '1');
            $('.slicknav_nav').css('transform', 'scaleY(1)');
        } else {
            // Close the menu
            $('.slicknav_nav').addClass('slicknav_hidden');
            $('.slicknav_nav').css('opacity', '0');
            $('.slicknav_nav').css('transform', 'scaleY(0)');
        }
    });
    
    // Pre-hover for improved UX - simulate hover states on load
    setTimeout(function() {
        // Add and remove hover state to first menu item to show user the hover effect
        const firstMenuItem = $('.slicknav_nav li:first-child a');
        firstMenuItem.addClass('hover-active');
        setTimeout(function() {
            firstMenuItem.removeClass('hover-active');
        }, 500);
    }, 1000);
    
    // Add active class to current menu item
    var currentUrl = window.location.href;
    $('.slicknav_nav li a').each(function() {
        if ($(this).attr('href') === currentUrl || currentUrl.indexOf($(this).attr('href')) > -1) {
            $(this).closest('.slicknav_item').addClass('active');
            // Ensure parent menu items are marked as active if a child is active
            $(this).parents('.slicknav_parent').addClass('active');
        }
    });

    // Create ripple effect on menu item click
    $('.slicknav_nav a').on('click', function(e) {
        let x = e.pageX - $(this).offset().left;
        let y = e.pageY - $(this).offset().top;
        
        let ripple = $('<span class="menu-ripple"></span>');
        ripple.css({
            left: x + 'px',
            top: y + 'px'
        });
        
        $(this).append(ripple);
        
        setTimeout(function() {
            ripple.remove();
        }, 600);
    });

    // Add keyframe animations to CSS
    var styleSheet = document.createElement('style');
    styleSheet.type = 'text/css';
    styleSheet.textContent = `
        .hover-active {
            background-color: rgba(255, 208, 0, 0.25) !important;
            color: #ffd000 !important;
            border-left: 3px solid #ffd000 !important;
        }
        
        .hover-active i.fa {
            color: #ffea00 !important;
        }
        
        .menu-ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 208, 0, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
            width: 100px;
            height: 100px;
            margin-left: -50px;
            margin-top: -50px;
        }
        
        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(styleSheet);
}); 