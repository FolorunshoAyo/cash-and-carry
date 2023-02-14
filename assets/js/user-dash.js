$(function(){
    const mobileMenuIcon = $(".menu-icon-container");
    const mobileMenu = $("aside.mobile-menu");
    const mobileBackdrop = $(".mobile-backdrop");
    const closeMenuEl = $(".cross-icon-container");

    mobileMenuIcon.on("click", function(){
        mobileMenu.addClass("active");
        mobileBackdrop.addClass("active");
    });

    closeMenuEl.on("click", function(){
        mobileMenu.removeClass("active");
        mobileBackdrop.removeClass("active");
    });

    mobileBackdrop.on("click", function(){
        mobileMenu.removeClass("active");
        mobileBackdrop.removeClass("active");
    })
});