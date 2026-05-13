<?php
// Register shortcode for event listing
add_shortcode('deam_events_listing', 'deam_events_listing_shortcode');
function deam_events_listing_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => -1,
        'layout' => 'list', // 'list' or 'grid'
    ), $atts);
    
    $args = array(
        'post_type' => 'deam_event',
        'posts_per_page' => $atts['posts_per_page'],
        'post_status' => 'publish',
        'meta_key' => '_deam_event_start_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );
    
    $events = new WP_Query($args);
    
    ob_start();
    
    if ($events->have_posts()) {
        echo '<div class="deam-events-list">';
        while ($events->have_posts()) {
            $events->the_post();
            $event_id = get_the_ID();
            $event_title = get_the_title();
            $event_description = get_the_content();
            $event_location = get_post_meta($event_id, '_deam_event_location', true);
            $start_date = get_post_meta($event_id, '_deam_event_start_date', true);
            $end_date = get_post_meta($event_id, '_deam_event_end_date', true);
            
            // Determine event status
            $current_time = current_time('Y-m-d H:i:s');
            $status = ($end_date < $current_time) ? 'past' : 'upcoming';
            $status_text = ($end_date < $current_time) ? 'Past Event' : 'Upcoming';
            
            // Format date for display
            $event_day = date('j', strtotime($start_date));
            $event_month = date('M', strtotime($start_date));
            $event_time = date('g:i A', strtotime($start_date));
            
            // Get random attendee count for demo (you can replace with actual count if needed)
            $attendee_count = rand(2, 89);
            $attendee_text = $attendee_count . ' ' . ($attendee_count == 1 ? 'guest' : 'other guests');
            ?>
            
            <div class="deam-event-item" data-event-id="<?php echo $event_id; ?>">
                <a href="<?php echo get_permalink(); ?>" class="deam-event-link">
                    <div class="deam-event-row">
                        <!-- Date Box -->
                        <div class="deam-event-date-box">
                            <span class="deam-event-day"><?php echo $event_day; ?></span>
                            <span class="deam-event-month"><?php echo $event_month; ?></span>
                        </div>
                        
                        <!-- Event Details -->
                        <div class="deam-event-details">
                            <h3 class="deam-event-title"><?php echo esc_html($event_title); ?></h3>
                            <div class="deam-event-meta">
                                <span class="deam-event-time">
                                    ⏰ <?php echo $event_time; ?>
                                </span>
                                <?php if (!empty($event_location)): ?>
                                <span class="deam-event-location">
                                    📍 <?php echo esc_html($event_location); ?>
                                </span>
                                <?php endif; ?>
                                <span class="deam-event-attendees">
                                    👥 <?php echo $attendee_text; ?>
                                </span>
                                <span class="deam-event-status-badge <?php echo $status; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Arrow Indicator -->
                        <div class="deam-event-arrow">
                            →
                        </div>
                    </div>
                </a>
            </div>
            
            <?php
        }
        echo '</div>';
    } else {
        echo '<p class="deam-no-events">No events found. Please check back later!</p>';
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}