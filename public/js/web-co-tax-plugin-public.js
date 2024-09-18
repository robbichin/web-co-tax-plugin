jQuery(document).ready(function($) {
    // Check if a cookie is set, if not, assume taxes are included by default
    var taxesIncluded = Cookies.get('taxesIncluded') === 'true';

    // Function to toggle taxes
    function toggleTaxes() {
        taxesIncluded = !taxesIncluded;
        Cookies.set('taxesIncluded', taxesIncluded, { expires: 365 });

        // Reload the page to apply the changes
        location.reload();
    }

    // Display the link based on the current tax display setting
    var linkIcon = taxesIncluded ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M384 80c8.8 0 16 7.2 16 16V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V96c0-8.8 7.2-16 16-16H384zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"/></svg>';
    
    // Add a class to the body based on the tax display setting
    $('body').toggleClass('taxes-included', taxesIncluded).toggleClass('taxes-excluded', !taxesIncluded);

    // Add a class to the link based on the tax display setting
    $('.toggle-taxes').toggleClass('taxes-included', taxesIncluded).toggleClass('taxes-excluded', !taxesIncluded);

    // Add click event to the link
    $('.toggle-taxes').on('click', function(e) {
        e.preventDefault();
        toggleTaxes();
    });

    // Insert the button before the span element
    $('.toggle-taxes span').before(linkIcon);
});
