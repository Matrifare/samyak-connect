(function ($) {


    "use strict";


    /**
     * Page Preloader
     */
    $("#introLoader").introLoader({
        animation: {
            name: 'counterLoader',
            options: {
                ease: "easeOutSine",
                style: 'style-01',
                animationTime: 1000
            }
        }
    });


    /**
     * Sticky Header
     */
    $(".container-wrapper").waypoint(function () {
        $(".navbar.navbar-fixed-top").toggleClass("navbar-sticky");
        return false;
    }, {offset: "-20px"});


    /**
     * Main Menu Slide Down Effect
     */
    // Mouse-enter dropdown
    $('#navbar li').on("mouseenter", function () {
        $(this).find('ul').first().stop(true, true).delay(350).slideDown(500, 'easeInOutQuad');
    });
    // Mouse-leave dropdown
    $('#navbar li').on("mouseleave", function () {
        $(this).find('ul').first().stop(true, true).delay(100).slideUp(150, 'easeInOutQuad');
    });


    /**
     * Navbar Vertical - For example: use for dashboard menu
     */
    if (screen && screen.width > 767) {
        // Mouse-enter dropdown
        $('.navbar-vertical li').on("mouseenter", function () {
            $(this).find('ul').first().stop(true, true).delay(450).slideDown(500, 'easeInOutQuad');
        });

        // Mouse-leave dropdown
        $('.navbar-vertical li').on("mouseleave", function () {
            $(this).find('ul').first().stop(true, true).delay(0).slideUp(150, 'easeInOutQuad');
        });
    }

    /**
     * Slicknav - a Mobile Menu
     */
    var $slicknav_label;
    $('#responsive-menu').slicknav({
        duration: 500,
        easingOpen: 'easeInExpo',
        easingClose: 'easeOutExpo',
        closedSymbol: '<i class="fa fa-plus"></i>',
        openedSymbol: '<i class="fa fa-minus"></i>',
        prependTo: '#slicknav-mobile',
        allowParentLinks: true,
        label: ""
    });

    /**
     * Slicknav - a Dashboard Mobile Menu
     */
    var $slicknav_label;
    $('#responsive-menu-dashboard').slicknav({
        duration: 500,
        easingOpen: 'easeInExpo',
        easingClose: 'easeOutExpo',
        closedSymbol: '<i class="fa fa-plus"></i>',
        openedSymbol: '<i class="fa fa-minus"></i>',
        prependTo: '#slicknav-mobile-dashboard',
        allowParentLinks: true,
        label: "Dashboard Menu"
    });


    /**
     * Smooth scroll to anchor
     */
    $(function () {
        $('a.anchor[href*=#]:not([href=#])').on("click", function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: (target.offset().top - 70) // 70px offset for navbar menu
                    }, 1000);
                    return false;
                }
            }
        });
    });


    /**
     * Effect Bootstrap Dropdown
     */
    $('.bt-dropdown-click').on('show.bs.dropdown', function (e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideToggle(350);
    });
    $('.bt-dropdown-click').on('hide.bs.dropdown', function (e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideToggle(350);
    });

    $(document).on('click', '.dropdown-menu-form', function (e) {
        e.stopPropagation();
    });

    $(document).on('click', '.dropdown-menu-form button', function (e) {
        closeDropDownForm(e);
    });


    /**
     * Another Bootstrap Toggle
     */
    $('.another-toggle').each(function () {
        if ($('h4', this).hasClass('active')) {
            $(this).find('.another-toggle-content').show();
        }
    });
    $('.another-toggle h4').on("click", function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).next('.another-toggle-content').slideUp();
        } else {
            $(this).addClass('active');
            $(this).next('.another-toggle-content').slideDown();
        }
    });


    /**
     *  Arrow for Menu has sub-menu
     */
    if ($(window).width() > 992) {
        $(".navbar-arrow ul ul > li").has("ul").children("a").append("<i class='arrow-indicator fa fa-angle-right'></i>");
    }


    /**
     * Back To Top
     */
    $(window).scroll(function () {
        if ($(window).scrollTop() > 500) {
            $("#back-to-top").fadeIn(200);
        } else {
            $("#back-to-top").fadeOut(200);
        }
    });
    $('#back-to-top, .back-to-top').on("click", function () {
        $('html, body').animate({scrollTop: 0}, '800');
        return false;
    });


    /**
     * Equal Content and Sidebar by Js
     */
    var widthForEqualContentSidebar = $(window).width();
    if ((widthForEqualContentSidebar > 768)) {

        // placing objects inside variables
        var content = $('.equal-content-sidebar-by-js .content-wrapper');
        var sidebar = $('.equal-content-sidebar-by-js .sidebar-wrapper');

        // get content and sidebar height in variables
        var getContentHeight = content.outerHeight();
        var getSidebarHeight = sidebar.outerHeight();

        // check if content height is bigger than sidebar
        if (getContentHeight > getSidebarHeight) {
            sidebar.css('min-height', getContentHeight);
        }

        // check if sidebar height is bigger than content
        if (getSidebarHeight > getContentHeight) {
            content.css('min-height', getSidebarHeight);
        }
    }


    /**
     * Bootstrap Tooltip
     */
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    /**
     * Fancy - Custom Select
     */
    $('.custom-select').fancySelect(); // Custom select


    /**
     * Placeholder
     */
    $("input, textarea").placeholder();


    /**
     * Input Spinner
     */
    $(".form-spin").TouchSpin({
        buttondown_class: 'btn btn-spinner-down',
        buttonup_class: 'btn btn-spinner-up',
        buttondown_txt: '<i class="ion-minus"></i>',
        buttonup_txt: '<i class="ion-plus"></i>'
    });


    /**
     * Typeahead - autocomplete form
     */
    var data = {
        countries: ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda",
            "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
            "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
            "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burma",
            "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad",
            "Chile", "China", "Colombia", "Comoros", "Congo, Democratic Republic", "Congo, Republic of the",
            "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador",
            "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon",
            "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala", "Guinea",
            "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India",
            "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan",
            "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos",
            "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg",
            "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands",
            "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Mongolia", "Morocco", "Monaco",
            "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger",
            "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru",
            "Philippines", "Poland", "Portugal", "Romania", "Russia", "Rwanda", "Samoa", "San Marino",
            "Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone",
            "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain",
            "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan",
            "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
            "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States",
            "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"],
        capitals: ["Abu Dhabi", "Abuja", "Accra", "Adamstown", "Addis Ababa", "Algiers", "Alofi", "Amman", "Amsterdam",
            "Andorra la Vella", "Ankara", "Antananarivo", "Apia", "Ashgabat", "Asmara", "Astana", "Asunción", "Athens",
            "Avarua", "Baghdad", "Baku", "Bamako", "Bandar Seri Begawan", "Bangkok", "Bangui", "Banjul", "Basseterre",
            "Beijing", "Beirut", "Belgrade", "Belmopan", "Berlin", "Bern", "Bishkek", "Bissau", "Bogotá", "Brasília",
            "Bratislava", "Brazzaville", "Bridgetown", "Brussels", "Bucharest", "Budapest", "Buenos Aires", "Bujumbura",
            "Cairo", "Canberra", "Caracas", "Castries", "Cayenne", "Charlotte Amalie", "Chisinau", "Cockburn Town",
            "Conakry", "Copenhagen", "Dakar", "Damascus", "Dhaka", "Dili", "Djibouti", "Dodoma", "Doha", "Douglas",
            "Dublin", "Dushanbe", "Edinburgh of the Seven Seas", "El Aaiún", "Episkopi Cantonment", "Flying Fish Cove",
            "Freetown", "Funafuti", "Gaborone", "George Town", "Georgetown", "Georgetown", "Gibraltar", "King Edward Point",
            "Guatemala City", "Gustavia", "Hagåtña", "Hamilton", "Hanga Roa", "Hanoi", "Harare", "Hargeisa", "Havana",
            "Helsinki", "Honiara", "Islamabad", "Jakarta", "Jamestown", "Jerusalem", "Juba", "Kabul", "Kampala",
            "Kathmandu", "Khartoum", "Kiev", "Kigali", "Kingston", "Kingston", "Kingstown", "Kinshasa", "Kuala Lumpur",
            "Kuwait City", "Libreville", "Lilongwe", "Lima", "Lisbon", "Ljubljana", "Lomé", "London", "Luanda", "Lusaka",
            "Luxembourg", "Madrid", "Majuro", "Malabo", "Malé", "Managua", "Manama", "Manila", "Maputo", "Marigot",
            "Maseru", "Mata-Utu", "Mbabane Lobamba", "Melekeok Ngerulmud", "Mexico City", "Minsk", "Mogadishu", "Monaco",
            "Monrovia", "Montevideo", "Moroni", "Moscow", "Muscat", "Nairobi", "Nassau", "Naypyidaw", "N'Djamena",
            "New Delhi", "Niamey", "Nicosia", "Nicosia", "Nouakchott", "Nouméa", "Nukuʻalofa", "Nuuk", "Oranjestad",
            "Oslo", "Ottawa", "Ouagadougou", "Pago Pago", "Palikir", "Panama City", "Papeete", "Paramaribo", "Paris",
            "Philipsburg", "Phnom Penh", "Plymouth Brades Estate", "Podgorica Cetinje", "Port Louis", "Port Moresby",
            "Port Vila", "Port-au-Prince", "Port of Spain", "Porto-Novo Cotonou", "Prague", "Praia", "Cape Town",
            "Pristina", "Pyongyang", "Quito", "Rabat", "Reykjavík", "Riga", "Riyadh", "Road Town", "Rome", "Roseau",
            "Saipan", "San José", "San Juan", "San Marino", "San Salvador", "Sana'a", "Santiago", "Santo Domingo",
            "São Tomé", "Sarajevo", "Seoul", "Singapore", "Skopje", "Sofia", "Sri Jayawardenepura Kotte", "St. George's",
            "St. Helier", "St. John's", "St. Peter Port", "St. Pierre", "Stanley", "Stepanakert", "Stockholm", "Sucre",
            "Sukhumi", "Suva", "Taipei", "Tallinn", "Tarawa Atoll", "Tashkent", "Tbilisi", "Tegucigalpa", "Tehran",
            "Thimphu", "Tirana", "Tiraspol", "Tokyo", "Tórshavn", "Tripoli", "Tskhinvali", "Tunis", "Ulan Bator", "Vaduz",
            "Valletta", "The Valley", "Vatican City", "Victoria", "Vienna", "Vientiane", "Vilnius", "Warsaw",
            "Washington, D.C.", "Wellington", "West Island", "Willemstad", "Windhoek", "Yamoussoukro", "Yaoundé", "Yaren",
            "Yerevan", "Zagreb"]
    };

    $('#destination-search-3').typeahead({
        minLength: 2,
        order: "asc",
        group: true,
        maxItemPerGroup: 3,
        groupOrder: function () {

            var scope = this,
                sortGroup = [];

            for (var i in this.result) {
                sortGroup.push({
                    group: i,
                    length: this.result[i].length
                });
            }

            sortGroup.sort(
                scope.helper.sort(
                    ["length"],
                    false, // false = desc, the most results on top
                    function (a) {
                        return a.toString().toUpperCase()
                    }
                )
            );

            return $.map(sortGroup, function (val, i) {
                return val.group
            });
        },
        hint: true,
        emptyTemplate: 'No result for "{{query}}"',
        source: {
            country: {
                data: data.countries
            },
            capital: {
                data: data.capitals
            }
        },
        debug: true
    });


    /**
     * Star rating
     */
    $('.tripadvisor-by-attr').raty({
        path: 'images/raty',
        starHalf: 'tripadvisor-half.png',
        starOff: 'tripadvisor-off.png',
        starOn: 'tripadvisor-on.png',
        readOnly: true,
        round: {down: .2, full: .6, up: .8},
        half: true,
        space: false,
        score: function () {
            return $(this).attr('data-rating-score');
        }
    });

    $('.star-rating-12px').raty({
        path: 'images/raty',
        starHalf: 'star-half-sm.png',
        starOff: 'star-off-sm.png',
        starOn: 'star-on-sm.png',
        readOnly: true,
        round: {down: .2, full: .6, up: .8},
        half: true,
        space: false,
        score: function () {
            return $(this).attr('data-rating-score');
        }
    });


    /**
     * Slider and Carousel by slick.js
     */
    $('.slick-banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '0',
        focusOnSelect: true,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    dots: false,
                }
            }
        ]
    });
    $('.slick-hero-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '0',
        focusOnSelect: true,
        adaptiveHeight: true,
        autoplay: true,
        autoplaySpeed: 4500,
        pauseOnHover: true,
    });
    $('.slick-testimonial').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        arrows: false,
        fade: false,
        asNavFor: '.slick-testimonial-nav',
        adaptiveHeight: true,
    });
    $('.slick-testimonial-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 500,
        centerPadding: '0',
        asNavFor: '.slick-testimonial',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        infinite: true,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });


    /**
     * Show more-less content
     */
    $('.btn-more-less').on("click", function () {
        $(this).text(function (i, old) {
            return old == 'Show more' ? 'Show less' : 'Show more';
        });
    });


    /**
     * Sidebar sticky by Stickit
     */
    if ($(window).width() > 991) {
        $('#sticky-sidebar').stickit({
            top: 95,
            bottom: 200,
        });
    }


    /**
     * Responsive Tab by tabCollapse
     */
    $('#detailTab, #responsiveTab').tabCollapse({
        tabsClass: 'hidden-sm hidden-xs',
        accordionClass: 'visible-sm visible-xs'
    });


    /*
     @Author: Manish Gupta
     @Date: 29th March, 2018
     @Desc: To Validate Register & For Custom Validations
     */

    /*	function addClassWithText(context, style, text) {
     var showError = document.createElement("p");
     $(showError).addClass("errLabel no-padding text-"+style);
     $(showError).html(text);
     $(context).parent().parent().append(showError);
     }*/

    function validateRegister1() {
        var firstName = $("#register_firstname").valid();
        var lastName = $("#register_lastname").valid();
        var mobile = $("#register_mobile").valid();
        var email = $("#register_email").valid();
        var password = $("#register_password").valid();
        var day = $("#register_date").valid();
        var month = $("#register_month").valid();
        var year = $("#register_year").valid();
        var height = $("#register_height").valid();
        var gender = $("#register_gender").valid();
        var complexion = $("#register_complexion").valid();
        var profileBy = $("#register_profile_for").valid();
        if (firstName && lastName && mobile && email && password
            && day && month && year && height && gender && complexion && profileBy) {
            return true;
        } else {
            return false;
        }
    }

    function validateRegister2() {
        var religion = $("#register_religion_id").valid();
        var caste = $("#register_my_caste").valid();
        var mothertongue = $("#register_mothertongue").valid();
        var marital_status = $("#marital_status");
        var isMarried = marital_status.valid();
        var childs = true;
        if (marital_status.val() != 'Unmarried') {
            childs = $("#register_divorcee_child").valid();
        } else {
            childs = true;
        }
        var education_level = $("#edu_level").valid();
        var edu_field = $("#register_edu_field").valid();
        var edu_id = $("#edu_id").valid();
        var employed_in = $("#register_employed_in").valid();
        var occupation = $("#register_occupation").valid();
        var monthly_salary = $("#register_salary").valid();
        var annual_income = $("#register_annual_income").valid();
        if (religion && caste && mothertongue && isMarried && childs && education_level && edu_field && edu_id
            && employed_in && occupation && monthly_salary && annual_income) {
            return true;
        } else {
            return false;
        }
    }


    function validateRegister3() {
        var father_occupation = $("#register_father_occupation").valid();
        var mother_occupation = $("#register_mother_occupation").valid();
        var noOfBros = $("#register_brother_nos").valid();
        var noOfSis = $("#register_sister_nos").valid();
        var livingStatus = $("#register_living_status").valid();
        var houseOwnership = $("#register_house_ownership").valid();
        var bodyType = $("#register_body_type").valid();
        var disaility = $("#register_disability").valid();
        var familyOrigin = $("#family_origin").valid();
        var countryId = $("#country_id").valid();
        var city = $("#city").valid();
        var profileText = $("#register_profile_text").valid();
        if (father_occupation && mother_occupation && noOfBros && noOfSis && livingStatus && houseOwnership && bodyType
            && disaility && familyOrigin && countryId && city && profileText) {
            return true;
        } else {
            return false;
        }
    }


    function validateRegister4() {
        var lookingFor = $("#register_looking_for").valid();
        var partReligion = $("#register_part_religion").valid();
        var partCaste = $("#register_part_caste").valid();
        var partAgeFrom = $("#register_pform_age").valid();
        var partAgeTo = $("#register_pto_age").valid();
        var partAgeHeight = $("#register_part_height").valid();
        var partAgeHeightTo = $("#register_part_height_to").valid();
        var partEduLevel = $("#register_part_edu_level").valid();
        var partEduField = $("#register_part_edu_field").valid();
        var partOccupation = $("#register_part_occupation").valid();
        var partCountry = $("#register_part_country").valid();
        var partComplexion = $("#register_part_complexion").valid();
        var partCity = $("#register_part_city").valid();
        var partNativeCity = $("#register_part_native_city").valid();
        var partEmpIn = $("#register_part_emp_in").valid();
        if (lookingFor && partReligion && partCaste && partAgeFrom && partAgeTo && partAgeHeight && partAgeHeightTo && partEduLevel
            && partEduField && partOccupation && partCountry && partComplexion && partCity && partNativeCity && partEmpIn) {
            return true;
        } else {
            return false;
        }
    }

    $("#marital_status").change(function () {
        if ($("#marital_status").val() != 'Unmarried') {
            $("#divorcee_section").slideDown(300);
            $("#register_divorcee_child").attr("required", "true");
        } else {
            $("#divorcee_section").slideUp(300);
            $("#register_divorcee_child").removeAttr("required");
        }
    });


    $("#edit_profile_content").on('change', '#marital_status', function () {
        if ($("#marital_status").val() != 'Unmarried') {
            $("#divorcee_section").slideDown(300);
            $("#register_divorcee_child").attr("required", "true");
            $("#edit_children_status").slideDown(300);
            $("#children_status").attr("required", "true");
        } else {
            $("#divorcee_section").slideUp(300);
            $("#register_divorcee_child").removeAttr("required");
            $("#edit_children_status").slideUp(300);
            $("#children_status").removeAttr("required");
        }
    });

    /**
     * Sign-in Modal
     */
    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $formRegister2 = $('#register-form-2');
    var $formRegister3 = $('#register-form-3');
    var $formRegister4 = $('#register-form-4');
    var $divForms = $('#modal-login-form-wrapper');
    var $modalAnimateTime = 300;

    $('#login_register_btn').on("click", function () {
        modalAnimate($formLogin, $formRegister);
    });
    $('#register_login_btn').on("click", function () {
        modalAnimate($formRegister, $formLogin);
    });
    $('#login_lost_btn').on("click", function () {
        modalAnimate($formLogin, $formLost);
    });
    $('#lost_login_btn').on("click", function () {
        modalAnimate($formLost, $formLogin);
    });
    $('#lost_register_btn').on("click", function () {
        modalAnimate($formLost, $formRegister);
    });
    $('#register_page2_btn').on("click", function () {
        if (validateRegister1()) {
            modalAnimate($formRegister, $formRegister2);
        }
    });
    $('#register_page3_btn').on("click", function () {
        if (validateRegister2()) {
            modalAnimate($formRegister2, $formRegister3);
        }
    });
    $('#register_page4_btn').on("click", function () {
        if (validateRegister3()) {
            modalAnimate($formRegister3, $formRegister4);
        }
    });
    $("#register_me").on("click", function () {
        /*if (validateRegister4()) {
            submitRegisterForm();
        }*/
        if (validateRegister3()) {
            submitRegisterForm();
        }
    });
    $("#register_page2_prev_btn").on("click", function () {
        modalAnimate($formRegister2, $formRegister);
    });
    $("#register_page3_prev_btn").on("click", function () {
        modalAnimate($formRegister3, $formRegister2);
    });

    /*$("#register_page4_prev_btn").on("click", function () {
        modalAnimate($formRegister4, $formRegister3);
    });*/

    function modalAnimate($oldForm, $newForm) {
        /*var $oldH = $oldForm.height();
         var $newH = $newForm.height();
         $divForms.css("height",$oldH);
         $oldForm.fadeToggle($modalAnimateTime, function(){
         $divForms.animate({height: $newH}, $modalAnimateTime, function(){
         $newForm.fadeToggle($modalAnimateTime);
         });
         });*/
        $($oldForm).slideUp($modalAnimateTime);
        $($newForm).slideDown($modalAnimateTime);
    }

    /*
     @Author: Manish Gupta
     @Date: 01st April, 2018
     @Desc: To Submit the Register Form using Ajax
     */


    // Variable to store your files
    var files;

    // Add events
    $('input[type=file]').on('change', prepareUpload);

    // Grab the files and set them to our variable
    function prepareUpload(event) {
        files = event.target.files;
    }

    function submitRegisterForm() {
        $("#loader-animation-area").show();
        $("#showRegisterError").html("");
        if (validateRegister1() && validateRegister2() && validateRegister3()) {
            // Create a formdata object and add the files
            var dataString = new FormData();

            if (files !== undefined) {
                $.each(files, function (key, value) {
                    dataString.append(key, value);
                });
            }
            var form_data = $("#register-profile").serializeArray();
            $.each(form_data, function (key, input) {
                dataString.append(input.name, input.value);
            });
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "web-services/register", //Where to make Ajax calls
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                data: dataString,
                success: function (response) {
                    if (response.flag == 1) {
                        window.location.href = 'homepage';
                    } else if (response.flag == 2) {
                        modalAnimate($formRegister3, $formRegister);
                    }
                    if (response.result == 'failed') {
                        $("#showRegisterError").html(response.msg);
                    }
                },
                complete: function () {
                    $("#loader-animation-area").hide();
                }
            });
        }
    }

    $("#register_page2_btn").click(function (e) {
        if (validateRegister1()) {
            var dataString = new FormData();

            var form_data = $("#register-profile").serializeArray();
            $.each(form_data, function (key, input) {
                dataString.append(input.name, input.value);
            });
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "web-services/try_register", //Where to make Ajax calls
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                data: dataString,
                success: function (response) {
                    if (response.flag == 2) {
                        $("#showRegisterError").html(response.msg);
                        $("#register_page2_prev_btn").trigger("click");
                    }
                },
                complete: function () {
                    $("#loader-animation-area").hide();
                }
            });
        }
    });

    /**
     * Payment Method
     */

    $("div.payment-option-form").hide();

    $("input[name$='payments']").click(function () {
        var test = $(this).val();
        $("div.payment-option-form").hide();
        $("#" + test).show();
    });


    /**
     * Instagram Feed
     */
    /*function createPhotoElement(photo) {
     var innerHtml = $('<img>')
     .addClass('instagram-image')
     .attr('src', photo.images.thumbnail.url);

     innerHtml = $('<a>')
     .attr('target', '_blank')
     .attr('href', photo.link)
     .append(innerHtml);

     return $('<div>')
     .addClass('instagram-placeholder')
     .attr('id', photo.id)
     .append(innerHtml);
     }

     function didLoadInstagram(event, response) {

     var that = this;

     $.each(response.data, function(i, photo) {
     $(that).append(createPhotoElement(photo));
     });
     }

     $(document).ready(function() {

     $('#instagram').on('didLoadInstagram', didLoadInstagram);
     $('#instagram').instagram({
     count: 20,
     userId: 3301700665,
     accessToken: '3301700665.4445ec5.c3ba39ad7828412286c1563cac3f594b'
     });

     });*/

    //Prevent Copy Paste
    let page = window.location.href;
    if (!page.includes("edit-profile") && !page.includes("login") && !page.includes("register") && !page.includes('update-descriptions')
        && !page.includes("premium_member")) {
        $("body").on("contextmenu", function (e) {
            return false;
        });
    }

    $("#mobile_no_query").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $("#mobile_no_query_submit").submit(function (e) {
        $("#loader-animation-area").show();
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "web-services/submit_mobile_no", //Where to make Ajax calls
            dataType: 'json',
            data: $(this).serialize(),
            success: function (response) {
                if (response.result == 'success') {
                    $(".changing_area").html("<td class='text-center' style='color: white;'>You will soon get a call from us.</td>").fadeIn('slow');
                }
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
        e.preventDefault();
    });

    $("#photo_setting_btn").click(function () {
        $("#photo_setting_content").slideToggle('slow');
    });

    $("#set_photo_pass_btn, #edit_photo_pass_btn").click(function () {
        $(".photo_pass_field").slideToggle('slow');
    });


    $("#partner-expectations-form").submit(function (e) {
        if (validateRegister4()) {
            $("#loader-animation-area").show();
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "web-services/partner_expectations", //Where to make Ajax calls
                dataType: 'json',
                data: $(this).serialize(),
                success: function (response) {
                    $("#partner-expectations-response").html(response.msg);
                    if (response.result == 'success') {
                        $("#partner-expectations-response").addClass('text-success').removeClass('text-danger');
                        setTimeout(function () {
                            $("#partnerExpectationModal").modal("hide");
                            window.location.reload();
                        }, 1000);
                    } else {
                        $("#partner-expectations-response").addClass('text-danger').removeClass('text-success');
                    }
                },
                complete: function () {
                    $("#loader-animation-area").hide();
                }
            });
        }
        e.preventDefault();
    });

    $("#lost-form").submit(function (e) {
        $("#loader-animation-area").show();
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "web-services/forgot_password", //Where to make Ajax calls
            dataType: 'json',
            data: $(this).serialize(),
            success: function (response) {
                $("#response_forgot_password").html(response.msg);
                if (response.result == 'success') {
                    $("#response_forgot_password").addClass('text-success').removeClass('text-danger');
                    setTimeout(function () {
                        $("#loginModal").modal("hide");
                    }, 5000);
                } else {

                    $("#response_forgot_password").addClass('text-danger').removeClass('text-success');
                }
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
        e.preventDefault();
    });
})(jQuery);

function openEditProfileInModal() {
    $("#loader-animation-area").show();
    $(function () {
        var $iframe = $('#iframe');
        $iframe.ready(function () {
            $iframe.contents().find("body").html('Loading, please wait..');
            $("#editProfileModal").find('iframe').attr('src', 'edit_profile');
            $("#editProfileModal").modal('show');
        });
    });
    $("#loader-animation-area").hide();
}

function openProfileInModal(userId) {
    $("#loader-animation-area").show();
    $(function () {
        var $iframe = $('#iframe');
        $iframe.ready(function () {
            $iframe.contents().find("body").html('Loading, please wait..');
            $("#profileModal").find('iframe').attr('src', 'view_profile?userId=' + userId);
            $("#profileModal").modal('show');
        });
    });
    $("#loader-animation-area").hide();
}


function getContactDetail(toid) {
    $("#contentContactDetailModal").html("Please wait...");
    $.get("web-services/contact_detail?toid=" + toid,
        function (data) {
            $("#contentContactDetailModal").html(data);
        });
    $("#contactDetailModal").modal("show");
}

var $modalAnimateTime = 300;

function open_register() {
    $('#register-form-2').slideUp($modalAnimateTime);
    $('#register-form-3').slideUp($modalAnimateTime);
    $('#register-form-4').slideUp($modalAnimateTime);
    $("#login_register_btn").click();
    $("#loginModal").modal("show");
}

function open_login() {
    $('#register-form').slideUp($modalAnimateTime);
    $('#register-form-2').slideUp($modalAnimateTime);
    $('#register-form-3').slideUp($modalAnimateTime);
    $('#register-form-4').slideUp($modalAnimateTime);
    $("#register_login_btn").click();
    $("#lost-form").hide();
    $("#loginModal").modal("show");
}

function open_forgot_password() {
    $('#register-form').slideUp($modalAnimateTime);
    $('#register-form-2').slideUp($modalAnimateTime);
    $('#register-form-3').slideUp($modalAnimateTime);
    $('#register-form-4').slideUp($modalAnimateTime);
    $("#loginModal").modal("show");
}


function fillPartnerExpectations() {
    $("#partnerExpectationModal").modal("show");
}

function premium_member(planId) {
    $("#loader-animation-area").show();
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "web-services/premium_membership_selection", //Where to make Ajax calls
        dataType: 'json',
        data: {
            planId: planId
        },
        success: function (response) {
            if (response.result == 'success') {
                $("#membership_name").html(response.plan.plan_name + " MEMBERSHIP");
                $("#plan_amount").html(response.plan.plan_amount_type + " " + response.plan.plan_amount);
                $("#plan_duration").html(response.plan.plan_duration);
                $("#plan_contacts").html(response.plan.plan_contacts);
                $("#plan_msg").html(response.plan.plan_msg);
                $("#sub_total_price_plan").slideDown('slow');
                $('html, body').animate({
                    scrollTop: $("#sub_total_price_plan").offset().top
                }, 1000);
            } else if (response.result == 'login') {
                $('body').append(response.view);
            } else {
                alert("Some Error Occurred, please contact administrator.");
            }
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}

function redirect_to_payment() {
    $('#myModalLabel').modal('hide');
    window.location.href = 'premium_member';
}

function closeIFrame() {
    $('#iframe').remove();
}

function view_message_box(toId) {
    $("#msgContentModal").html("Please wait...");
    $.post("web-services/msg_view", {toId: toId},
        function (data) {
            $("#msgContentModal").html(data);
        });
    $("#sendMsgModal").modal("show");
}


function msgViewChange(type) {
    if (type === 'sms') {
        $(".show-form-message").slideUp(100);
        $(".show-form-sms").slideDown(100);
        $("#sendMessageBtn").html("Send SMS");
    } else if (type === 'message') {
        $(".show-form-sms").slideUp(100);
        $(".show-form-message").slideDown(100);
        $("#sendMessageBtn").html("Send Message");
    }
}

function change_heading(type) {
    if (type == 'Recently') {
        text = 'Recently Joined Premium Members';
    } else if (type == 'Recent') {
        text = 'Recently Joined Members';
    } else if (type == 'Bookmark') {
        text = 'My Bookmarked Profiles';
    } else if (type == 'Viewed') {
        text = 'My Contact Viewed Profiles';
    } else if (type == 'Visitor') {
        text = 'My Visitors Profiles';
    } else if (type == 'Blocklist') {
        text = 'My Blocklisted Profiles';
    } else if (type == 'Viewed_My_Contacts') {
        text = 'Who Viewed My Contact';
    } else {
        text = 'Recently Joined Premium Members';
    }
    $("#current_heading").html(text);
}

function uploadPhoto(context) {
    $("#loader-animation-area").show();
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "page-parts/change_photo_view", //Where to make Ajax calls
        dataType: 'html',
        data: {
            photo: $(context).data('image'),
        },
        success: function (response) {
            $("#updateContentPhoto").html(response);
            $("#updatePhotoModal").modal('show');
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}


/*
 For Uploading Files
 */
$("#updateContentPhoto").on('submit', '#change_photo_form', function (e) {
    $("#loader-animation-area").show();
    var formData = new FormData(this);
    formData.append("photoNo", $("#change_photo_form").data('image'));
    $.ajax({
        url: 'web-services/photo_submit',
        type: 'POST',
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.result == 'success') {
                $("#change_photo_response").addClass('text-success').removeClass('text-danger').html("Successfuly Uploaded the image");
                $("#" + response.photoNo).attr('src', response.new_image);
                $("#delete_" + response.photoNo).removeClass('hidden');
                $("#updatePhotoModal").modal('hide');
            } else {
                $("#change_photo_response").addClass('text-danger').removeClass('text-success').html(response.msg);
            }
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
    e.preventDefault();
});

function showPhoto(imageSource) {
    $("#viewContentPhoto").html("<img src='" + imageSource + "' class='img-responsive' style='width: 100%; box-shadow: 4px 5px 5px 2px #999; border: 4px solid #E8EAEB;'/>");
    $("#viewPhotoModal").modal("show");
}

function deletePhoto(context) {
    $("#loader-animation-area").show();
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "web-services/delete_photo", //Where to make Ajax calls
        dataType: 'json',
        data: {
            photo: $(context).data('image'),
        },
        success: function (response) {
            if (response.result == 'success') {
                $("#" + response.photoNo).attr('src', response.new_image);
                $("#delete_" + response.photoNo).addClass('hidden');
            } else {
                alert("Failed to delete.");
            }
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}

function photoSettings(setting) {
    if (setting == "0" || setting == "2") {
        $("#photo_pass_btn").slideDown('slow');
        updatePhotoSettings(0);
    } else if (setting == "1") {
        $("#photo_pass_btn").slideUp('fast');
        updatePhotoSettings(1);
    } else {
        $("#photo_pass_btn").slideUp('fast');
        $("#response_photo_settings").html("Invalid Input Error");
    }
}

function updatePhotoSettings(setting) {
    /*if ((setting == 0 || setting == 2) && $("#photo_pass").val() == '') {
     alert("Photo Password should not be blank");
     return false;
     } else {*/
    $("#loader-animation-area").show();
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "web-services/photo_settings", //Where to make Ajax calls
        dataType: 'json',
        data: $("#photo_visibility_form").serialize() + "&remove=" + setting,
        success: function (response) {
            $("#response_photo_settings").html(response.msg);
            if (response.result == 'success') {
                $("#photo_setting_content,.photo_pass_field, #photo_pass_btn").slideUp("fast");
            }
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
    /*}*/
}


$(document).on('submit', "#send_message_form", function (e) {
    $("#loader-animation-area").show();
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "web-services/send_message", //Where to make Ajax calls
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            try {
                if (response.result == 'success') {
                    $("#response_text").html("Message successfully sent to " + response.toId);
                    $("#msg_text").html("");
                    setTimeout(function () {
                        $("#sendMsgModal").modal("hide");
                    }, 2000)
                } else if (response.result == 'expired') {
                    $("#response_text").html('Your membership is expired or you are not a paid member, please upgrade your membership now by ' +
                        'clicking <a href="premium_member">here</a>');
                } else if (response.result == 'blocked') {
                    $("#response_text").html(response.toId + " has blocked you. You can\'t send messages to this ID anymore...");
                } else {
                    alert("Something went wrong");
                }
            } catch (e) {
                alert("Something went wrong");
            }

        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
    e.preventDefault();
});

$("#forgot_password_page_form").submit(function (e) {
    $("#loader-animation-area").show();
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "web-services/forgot_password_page", //Where to make Ajax calls
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            try {
                if (response.result == 'success') {
                    $(".verify_mobile_forgot_password").slideUp();
                    $(".verify_otp_forgot_password").slideDown();
                    $("#response_forgot_password").html(response.msg).slideDown();
                    setTimeout(function () {
                        $("#response_forgot_password").html(response.msg).fadeOut();
                    }, 30000);
                    if (response.result1 == 'success_otp') {
                        $("#response_forgot_password").html(response.msg).slideDown();
                        $("#response_forgot_password").append('<br/><br/><a href="index" title="Click to go to homepage">Click Here to go to Homepage</a> ');
                        $("#forgot_password_page_form").fadeOut();
                    }
                } else if (response.result == 'failed') {
                    alert(response.msg);
                } else {
                    alert("Something went wrong");
                }
            } catch (e) {
                alert("Something went wrong");
            }

        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
    e.preventDefault();
});

$(function () {
    $("#btnCloseHomeScreen").click(function (e) {
        $(".home_screen_popup").fadeOut('slow');
    });
});


function openRightSideMenu() {
    $(".right-side-menu-new").width(270);
}

function closeRightSideMenu() {
    $(".right-side-menu-new").width(0);
}

function removeWhiteSpace(context) {
    var str = $(context).val().replaceAll(" ", "");
    $(context).val(str);
}


/*function validateField(p, i, val) {
    let compareVal = $('#' + i).val();
    if (p == 'start' && compareVal <= val) {
        if(i.includes("Age")) {
            alert("From age should not be greater than to age");
            return false;
        } else if(i.includes("Height")) {
            alert("From height should not be greater than to height");
            return false;
        }
    }
    if (p == 'end' && compareVal >= val) {
        if(i.includes("Age")) {
            alert("To age should not be less than from age");
            return false;
        } else if(i.includes("Height")) {
            alert("To height should not be less than from height");
            return false;
        }
    }
    return true;
}*/

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('service-worker.js').then(function (registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request)
            .then(function (response) {
                    // Cache hit - return response
                    if (response) {
                        return response;
                    }
                    return fetch(event.request);
                }
            )
    );
});
// importScripts('js/polyfill.js');
self.addEventListener('install', function (e) {
    e.waitUntil(
        caches.open('samyak').then(function (cache) {
            return cache.addAll([
                '/',
                '/index.php',
                'bootstrap/css/bootstrap.min.css',
                'css/animate.css',
                'css/main.css?v=1.0',
                'css/component.css',
                'css/template.css?v=1.0'
            ]);
        })
    );
});
