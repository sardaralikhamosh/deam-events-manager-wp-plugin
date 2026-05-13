<?php
/**
 * Single Event Template
 */

get_header();

while (have_posts()) : the_post();
    $event_id = get_the_ID();
    $event_title = get_the_title();
    $event_description = get_the_content();
    $event_location = get_post_meta($event_id, '_deam_event_location', true);
    $event_organizer = get_post_meta($event_id, '_deam_event_organizer', true);
    $start_date = get_post_meta($event_id, '_deam_event_start_date', true);
    $end_date = get_post_meta($event_id, '_deam_event_end_date', true);
    $featured_image = get_the_post_thumbnail_url($event_id, 'large');
    $gallery_images = get_post_meta($event_id, '_deam_event_gallery', true);
    $gallery_images = $gallery_images ? explode(',', $gallery_images) : array();
    
    // Format dates
    $start_date_formatted = date('F j, Y', strtotime($start_date));
    $start_time_formatted = date('g:i A', strtotime($start_date));
    $end_date_formatted = date('F j, Y', strtotime($end_date));
    $end_time_formatted = date('g:i A', strtotime($end_date));
    ?>
    
    <div class="deam-single-event">
        <div class="deam-container">
            <!-- Event Header -->
            <div class="deam-event-header">
                <h1 class="deam-event-main-title"><?php echo esc_html($event_title); ?></h1>
            </div>
            
            <?php if ($featured_image): ?>
            <div class="deam-event-hero">
                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($event_title); ?>">
            </div>
            <?php endif; ?>
            
            <!-- Event Information Grid -->
            <div class="deam-event-info-grid">
                <div class="deam-info-card">
                    <div class="deam-info-icon">📍</div>
                    <div class="deam-info-content">
                        <h3>Location</h3>
                        <p><?php echo esc_html($event_location); ?></p>
                    </div>
                </div>
                
                <div class="deam-info-card">
                    <div class="deam-info-icon">📅</div>
                    <div class="deam-info-content">
                        <h3>Date & Time</h3>
                        <p><strong>Start:</strong> <?php echo $start_date_formatted; ?> at <?php echo $start_time_formatted; ?></p>
                        <p><strong>End:</strong> <?php echo $end_date_formatted; ?> at <?php echo $end_time_formatted; ?></p>
                    </div>
                </div>
                
                <div class="deam-info-card">
                    <div class="deam-info-icon">👤</div>
                    <div class="deam-info-content">
                        <h3>Organizer</h3>
                        <p><?php echo esc_html($event_organizer); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Event Description -->
            <div class="deam-event-description">
                <h2>About This Event</h2>
                <?php echo apply_filters('the_content', $event_description); ?>
            </div>
            
            <!-- Event Gallery -->
            <?php if (!empty($gallery_images)): ?>
            <div class="deam-event-gallery">
                <h2>Event Gallery</h2>
                <div class="deam-gallery-grid">
                    <?php foreach ($gallery_images as $image_id): ?>
                        <?php $image_url = wp_get_attachment_image_url($image_id, 'medium'); ?>
                        <div class="deam-gallery-item">
                            <img src="<?php echo esc_url($image_url); ?>" alt="Gallery Image">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Registration Button -->
            <div class="deam-registration-section">
                <button class="deam-book-now-btn" data-event-id="<?php echo $event_id; ?>">
                    Book Now
                </button>
            </div>
        </div>
    </div>
    
    <?php 
    // Include the registration form template
    // Set global variable for event ID to be used in the template
    $GLOBALS['current_event_id'] = $event_id;
    include DEAM_EVENTS_PLUGIN_DIR . 'templates/registration-form.php';
    ?>
    
<?php endwhile;

get_footer();
?>