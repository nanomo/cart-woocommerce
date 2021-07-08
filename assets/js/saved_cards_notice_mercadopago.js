/* globals ajaxurl */
jQuery(document).ready(function ($) {
    $(document).on('click', '#saved-cards-notice', function () {
        $.post( ajaxurl, { action: 'mercadopago_review_dismiss' } );
      }
    );
  });
  