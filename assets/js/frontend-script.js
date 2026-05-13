jQuery(document).ready(function($) {
    // Handle Book Now button click on single event page
    $('.deam-book-now-btn').on('click', function() {
        var eventId = $(this).data('event-id');
        if (typeof window.openRegistrationModal === 'function') {
            window.openRegistrationModal(eventId);
        } else {
            // Fallback: find modal and set event ID
            var modal = $('#deam-registration-modal');
            $('#deam-registration-form input[name="event_id"]').val(eventId);
            modal.fadeIn(200);
            $('body').css('overflow', 'hidden');
        }
    });
});