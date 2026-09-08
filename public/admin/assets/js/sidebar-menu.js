(function ($) {
    $(".toggle-nav").click(function () {
        $("#sidebar-links .nav-menu").css("left", "0px");
    });
    $(".mobile-back").click(function () {
        $("#sidebar-links .nav-menu").css("left", "-410px");
    });
    $(".page-wrapper").attr(
        "class",
        "page-wrapper " + localStorage.getItem("page-wrapper")
    );
    if (localStorage.getItem("page-wrapper") === null) {
        $(".page-wrapper").addClass("compact-wrapper");
    }
  
    // left sidebar and vertical menu
    if ($("#pageWrapper").hasClass("compact-wrapper")) {
        $(".sidebar-title").append(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
        );
        $(".sidebar-title").click(function () {
            $(".sidebar-title")
                .removeClass("active")
                .find("div")
                .replaceWith(
                    '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
            $(".sidebar-submenu, .menu-content").slideUp("normal");
            $(".menu-content").slideUp("normal");
            if ($(this).next().is(":hidden") == true) {
                $(this).addClass("active");
                $(this)
                    .find("div")
                    .replaceWith(
                        '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                    );
                $(this).next().slideDown("normal");
            } else {
                $(this)
                    .find("div")
                    .replaceWith(
                        '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                    );
            }
        });
        $(".sidebar-submenu, .menu-content").hide();
        $(".submenu-title").append(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
        );
        $(".submenu-title").click(function () {
            $(".submenu-title")
                .removeClass("active")
                .find("div")
                .replaceWith(
                    '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
            $(".submenu-content").slideUp("normal");
            if ($(this).next().is(":hidden") == true) {
                $(this).addClass("active");
                $(this)
                    .find("div")
                    .replaceWith(
                        '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                    );
                $(this).next().slideDown("normal");
            } else {
                $(this)
                    .find("div")
                    .replaceWith(
                        '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                    );
            }
        });
        $(".submenu-content").hide();
    } else if ($("#pageWrapper").hasClass("horizontal-wrapper")) {
        var smallSize = false,
            bigSize = false;
        const horizontalMenu = () => {
            var contentwidth = $(window).width();
            if (contentwidth <= 992 && !smallSize) {
                (smallSize = true), (bigSize = false);
                $("#pageWrapper")
                    .removeClass("horizontal-wrapper")
                    .addClass("compact-wrapper");
                $(".page-body-wrapper")
                    .removeClass("horizontal-menu")
                    .addClass("sidebar-icon");
                $(".submenu-title").append(
                    '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
                $(".submenu-title").click(function () {
                    $(".submenu-title").removeClass("active");
                    $(".submenu-title")
                        .find("div")
                        .replaceWith(
                            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                        );
                    $(".submenu-content").slideUp("normal");
                    if ($(this).next().is(":hidden") == true) {
                        $(this).addClass("active");
                        $(this)
                            .find("div")
                            .replaceWith(
                                '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                            );
                        $(this).next().slideDown("normal");
                    } else {
                        $(this)
                            .find("div")
                            .replaceWith(
                                '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                            );
                    }
                });
                $(".submenu-content").hide();
  
                $(".sidebar-title").append(
                    '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
                $(".sidebar-title").click(function () {
                    $(".sidebar-title").removeClass("active");
                    $(".sidebar-title")
                        .find("div")
                        .replaceWith(
                            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                        );
                    $(".sidebar-submenu, .menu-content").slideUp("normal");
                    if ($(this).next().is(":hidden") == true) {
                        $(this).addClass("active");
                        $(this)
                            .find("div")
                            .replaceWith(
                                '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                            );
                        $(this).next().slideDown("normal");
                    } else {
                        $(this)
                            .find("div")
                            .replaceWith(
                                '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                            );
                    }
                });
                $(".sidebar-submenu, .menu-content").hide();
            }
            if (contentwidth > 992 && !bigSize) {
                (smallSize = false), (bigSize = true);
                $("#pageWrapper")
                    .removeClass("compact-wrapper")
                    .addClass("horizontal-wrapper");
                $(".sidebar-title .according-menu").remove();
            }
        };
        horizontalMenu();
        addEventListener("resize", (event) => {
            horizontalMenu();
        });
    } else if ($("#pageWrapper").hasClass("compact-sidebar")) {
        var contentwidth = $(window).width();
        if (contentwidth > 992) {
            $('<div class="bg-overlay1"></div>').appendTo($("body"));
        }
  
        $(".sidebar-title").click(function () {
            $(".sidebar-title").removeClass("active");
            $(".bg-overlay1").removeClass("active");
            $(".sidebar-submenu")
                .removeClass("close-submenu")
                .slideUp("normal");
            $(".sidebar-submenu, .menu-content").slideUp("normal");
            $(".menu-content").slideUp("normal");
  
            if ($(this).next().is(":hidden") == true) {
                $(this).addClass("active");
                $(this).next().slideDown("normal");
                $(".bg-overlay1").addClass("active");
  
                $(".bg-overlay1").on("click", function () {
                    $(".sidebar-submenu, .menu-content").slideUp("normal");
                    $(this).removeClass("active");
                });
            }
            if (contentwidth < "992") {
                $(".bg-overlay").addClass("active");
            }
        });
        $(".sidebar-submenu, .menu-content").hide();
        $(".submenu-title").append(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
        );
        $(".submenu-title").click(function () {
            $(".submenu-title")
                .removeClass("active")
                .find("div")
                .replaceWith(
                    '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
            $(".submenu-content").slideUp("normal");
            if ($(this).next().is(":hidden") == true) {
                $(this).addClass("active");
                $(this)
                    .find("div")
                    .replaceWith(
                        '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                    );
                $(this).next().slideDown("normal");
            } else {
                $(this)
                    .find("div")
                    .replaceWith(
                        '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                    );
            }
        });
        $(".submenu-content").hide();
    }
  
    // toggle sidebar
    $nav = $(".sidebar-wrapper");
    $header = $(".page-header");
    $toggle_nav_top = $(".toggle-sidebar");
    $toggle_nav_top.click(function () {
        $nav.toggleClass("close_icon");
        $header.toggleClass("close_icon");
        $(window).trigger("overlay");
    });
  
    $(window).on("overlay", function () {
        $bgOverlay = $(".bg-overlay");
        $isHidden = $nav.hasClass("close_icon");
        if ($(window).width() <= 991 && !$isHidden && $bgOverlay.length === 0) {
            $('<div class="bg-overlay active"></div>').appendTo($("body"));
        }
  
        if ($isHidden && $bgOverlay.length > 0) {
            $bgOverlay.remove();
        }
    });
  
    $(".sidebar-wrapper .back-btn").on("click", function (e) {
        $(".page-header").toggleClass("close_icon");
        $(".sidebar-wrapper").toggleClass("close_icon");
        $(window).trigger("overlay");
    });
  
    $("body").on("click", ".bg-overlay", function () {
        $header.addClass("close_icon");
        $nav.addClass("close_icon");
        $(this).remove();
    });
  
    $body_part_side = $(".body-part");
    $body_part_side.click(function () {
        $toggle_nav_top.attr("checked", false);
        $nav.addClass("close_icon");
        $header.addClass("close_icon");
    });
  
    //    responsive sidebar
    var $window = $(window);
    var widthwindow = $window.width();
    (function ($) {
        "use strict";
        if (widthwindow <= 991) {
            $toggle_nav_top.attr("checked", false);
            $nav.addClass("close_icon");
            $header.addClass("close_icon");
        }
    })(jQuery);
    $(window).resize(function () {
        var widthwindaw = $window.width();
        if (widthwindaw <= 991) {
            $toggle_nav_top.attr("checked", false);
            $nav.addClass("close_icon");
            $header.addClass("close_icon");
        } else {
            $toggle_nav_top.attr("checked", true);
            $nav.removeClass("close_icon");
            $header.removeClass("close_icon");
        }
    });
  
    // horizontal arrows
    var view = $("#sidebar-menu");
    var move = "500px";
    var leftsideLimit = -500;
  
    var getMenuWrapperSize = function () {
        return $(".sidebar-wrapper").innerWidth();
    };
    var menuWrapperSize = getMenuWrapperSize();
  
    if (menuWrapperSize >= "1660") {
        var sliderLimit = -3500;
    } else if (menuWrapperSize >= "1440") {
        var sliderLimit = -3600;
    } else {
        var sliderLimit = -4200;
    }
  
    $("#left-arrow").addClass("disabled");
    $("#right-arrow").click(function () {
        var currentPosition = parseInt(view.css("marginLeft"));
        if (currentPosition >= sliderLimit) {
            $("#left-arrow").removeClass("disabled");
            view.stop(false, true).animate(
                {
                    marginLeft: "-=" + move,
                },
                {
                    duration: 400,
                }
            );
            if (currentPosition == sliderLimit) {
                $(this).addClass("disabled");
                console.log("sliderLimit", sliderLimit);
            }
        }
    });
  
    $("#left-arrow").click(function () {
        var currentPosition = parseInt(view.css("marginLeft"));
        if (currentPosition < 0) {
            view.stop(false, true).animate(
                {
                    marginLeft: "+=" + move,
                },
                {
                    duration: 400,
                }
            );
            $("#right-arrow").removeClass("disabled");
            $("#left-arrow").removeClass("disabled");
            if (currentPosition >= leftsideLimit) {
                $(this).addClass("disabled");
            }
        }
    });
  
    // === Update Sidebar Active Javascript
    $(document).ready(function () {
        if ($("#pageWrapper").hasClass("compact-wrapper")) {
            $(".sidebar-wrapper nav").find("a, li").removeClass("active");

            // Match on the URL PATH and pick the LONGEST (most specific) matching link,
            // so e.g. /manage-ipo does not win over /manage-ipo-drhp on a DRHP page.
            var currentPath = window.location.pathname.replace(/\/+$/, "");
            var bestLink = null;
            var bestLen = -1;

            $(".sidebar-wrapper nav ul li a").each(function () {
                var href = $(this).attr("href");
                if (!href || href === "#") return;

                var linkPath;
                try {
                    linkPath = new URL(href, window.location.origin).pathname.replace(/\/+$/, "");
                } catch (e) {
                    return;
                }
                if (!linkPath) return; // skip root / empty

                // current path equals the link, or is a sub-route of it (…/create, …/1/edit)
                if (currentPath === linkPath || currentPath.indexOf(linkPath + "/") === 0) {
                    if (linkPath.length > bestLen) {
                        bestLen = linkPath.length;
                        bestLink = $(this);
                    }
                }
            });

            if (bestLink) {
                bestLink.addClass("active");
                bestLink.parents("ul").css("display", "block"); // open every ancestor menu
                bestLink.parents("li").children("a").each(function () {
                    $(this).addClass("active");
                    // flip the accordion arrow to "open" for active ancestors
                    var arrow = $(this).find(".according-menu");
                    if (arrow.length === 0) {
                        $(this).append('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
                    } else {
                        arrow.html('<i class="fa fa-angle-down"></i>');
                    }
                });
            } else {
                // Hide all dropdowns if no tab is active
                $(".sidebar-wrapper nav ul").css("display", "none");
            }
        }
    });
   
  })($);