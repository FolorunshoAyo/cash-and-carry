$(function(){
    const aside = $(".dash-menu");
    const icon = $(".menu-icon");
    const li = $(".nav-item");
    const mobileBackdrop =$(".mobile-backdrop");
    const dropdownBtn = $(".arrow-container");
    const dropdownMenu = $(".dropdown-menu");
    
    // EXPAND DASH MENU FUNCTIONALITY ON BUTTON CLICK
    icon.on("click", function(){
        aside.toggleClass("expand");
        mobileBackdrop.toggleClass("display");
    });
    
    // NAVIGATION LINK DROPDOWN FUNCTIONALITY START
    new MetisMenu('#side-menu',{
        // selector of parent trigger
        parentTrigger: "li",
        // selector of submenu
        subMenu: "ul",
        // enable auto collapse
        toggle: true,
        // trigger element
        triggerElement: "a"
        
    });


    // DROPDOWN BUTTON FUNCTONALITY 
    dropdownBtn.on("click", function() {
        dropdownBtn.toggleClass("active");
        dropdownMenu.toggleClass("active");
    });
       
});