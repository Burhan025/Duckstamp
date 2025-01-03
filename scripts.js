//Change div position
jQuery(document).ready(function() {
    // Iterate over each 'pp-content-post-data' div inside '#full-product'
    jQuery('#full-product .pp-content-post-data').each(function() {
        // Find the 'pp-add-to-cart' within the current 'pp-content-post-data' and move it after the 'pp-content-post-data' div
        jQuery(this).find('.pp-add-to-cart.pp-post-link').insertAfter(jQuery(this));
    });
});

//Change div position
jQuery(document).ready(function() {
    // Iterate over each 'pp-content-post-data' div inside '#full-product'
    jQuery('.single-product .pp-content-post-data').each(function() {
        // Find the 'pp-add-to-cart' within the current 'pp-content-post-data' and move it after the 'pp-content-post-data' div
        jQuery(this).find('.pp-add-to-cart.pp-post-link').insertAfter(jQuery(this));
    });
});


//Add class to chatbot and onclick function
jQuery(document).ready(function() {
    // Add class "openChat" to the elements
    jQuery('.chatbot .pp-dual-button-2.pp-dual-button a.pp-button').addClass('openChat');

    // Handle the click event for all elements with class "openChat"
    jQuery('.openChat').on('click', function(event) {
      // Prevent the default link behavior (i.e., prevent page reload)
      event.preventDefault();

      // Open the Zendesk Messaging widget
      if (typeof zE !== 'undefined') {
        zE('messenger', 'open');
      } else {
        console.log("Zendesk Messaging is not initialized yet.");
      }
    });
});

//Add class to chatbot and onclick function
jQuery(document).ready(function() {
  // Add class "openChat" to the elements
  jQuery('.botchat .fl-button-wrap a.fl-button').addClass('openChat');

  // Handle the click event for all elements with class "openChat"
  jQuery('.openChat').on('click', function(event) {
    // Prevent the default link behavior (i.e., prevent page reload)
    event.preventDefault();

    // Open the Zendesk Messaging widget
    if (typeof zE !== 'undefined') {
      zE('messenger', 'open');
    } else {
      console.log("Zendesk Messaging is not initialized yet.");
    }
  });
});