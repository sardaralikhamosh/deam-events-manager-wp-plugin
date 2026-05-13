<?php
// Handle registration form submission
add_action('wp_ajax_deam_events_register', 'deam_events_handle_registration');
add_action('wp_ajax_nopriv_deam_events_register', 'deam_events_handle_registration');

function deam_events_handle_registration() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'deam_events_nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    // Validate required fields
    $required_fields = ['name', 'contact_number', 'email', 'address', 'nationality', 'gender'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error("Please fill in all required fields");
        }
    }
    
    // Sanitize data
    $event_id = intval($_POST['event_id']);
    $name = sanitize_text_field($_POST['name']);
    $contact_number = sanitize_text_field($_POST['contact_number']);
    $email = sanitize_email($_POST['email']);
    $address = sanitize_textarea_field($_POST['address']);
    $nationality = sanitize_text_field($_POST['nationality']);
    $gender = sanitize_text_field($_POST['gender']);
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error("Invalid email address");
    }
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'deam_event_registrations';
    
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'event_id' => $event_id,
            'name' => $name,
            'contact_number' => $contact_number,
            'email' => $email,
            'address' => $address,
            'nationality' => $nationality,
            'gender' => $gender,
            'registration_date' => current_time('mysql'),
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($inserted) {
        // Send email to admin
        $event_title = get_the_title($event_id);
        $admin_email = get_option('admin_email');
        $subject = "New Event Registration: $event_title";
        
        $message = "A new registration has been submitted:\n\n";
        $message .= "Event: $event_title\n";
        $message .= "Name: $name\n";
        $message .= "Contact Number: $contact_number\n";
        $message .= "Email: $email\n";
        $message .= "Address: $address\n";
        $message .= "Nationality: $nationality\n";
        $message .= "Gender: $gender\n";
        
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        wp_mail($admin_email, $subject, $message, $headers);
        
        wp_send_json_success("Registration successful! A confirmation has been sent to the administrator.");
    } else {
        wp_send_json_error("Failed to save registration. Please try again.");
    }
}