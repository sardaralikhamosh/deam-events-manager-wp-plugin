<?php
/**
 * Template for displaying event listing
 * This can be used as a standalone template or called from shortcode
 */

if (!defined('ABSPATH')) {
    exit;
}

// Query arguments
$args = array(
    'post_type' => 'deam_event',
    'posts_per_page' => $atts['posts_per_page'] ?? -1,
    'post_status' => 'publish',
    'meta_key' => '_deam_event_start_date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
);

$events = new WP_Query($args);

if ($events->have_posts()) : ?>
    <div class="deam-events-grid">
        <?php while ($events->have_posts()) : $events->the_post();
            $event_id = get_the_ID();
            $event_title = get_the_title();
            $event_description = get_the_content();
            $event_location = get_post_meta($event_id, '_deam_event_location', true);
            $start_date = get_post_meta($event_id, '_deam_event_start_date', true);
            $end_date = get_post_meta($event_id, '_deam_event_end_date', true);
            $featured_image = get_the_post_thumbnail_url($event_id, 'medium');
            
            // Determine event status
            $current_time = current_time('Y-m-d H:i:s');
            $status = ($end_date < $current_time) ? 'Past Event' : 'Upcoming Event';
            $status_class = ($end_date < $current_time) ? 'past' : 'upcoming';
            
            // Get mini description (first 20 words)
            $mini_description = wp_trim_words($event_description, 20, '...');
            
            // Format dates
            $start_time_display = date('M d, Y g:i A', strtotime($start_date));
            $end_time_display = date('M d, Y g:i A', strtotime($end_date));
            ?>
            
            <div class="deam-event-card">
                <?php if ($featured_image) : ?>
                    <div class="deam-event-image">
                        <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($event_title); ?>">
                    </div>
                <?php endif; ?>
                
                <div class="deam-event-content">
                    <h3 class="deam-event-title"><?php echo esc_html($event_title); ?></h3>
                    <p class="deam-event-mini-desc"><?php echo esc_html($mini_description); ?></p>
                    
                    <div class="deam-event-meta">
                        <div class="deam-event-location">
                            <span class="dashicons dashicons-location"></span> 
                            <span><?php echo esc_html($event_location); ?></span>
                        </div>
                        <div class="deam-event-time">
                            <span class="dashicons dashicons-clock"></span> 
                            <span>Start: <?php echo $start_time_display; ?></span>
                        </div>
                        <div class="deam-event-end-time">
                            <span class="dashicons dashicons-clock"></span> 
                            <span>End: <?php echo $end_time_display; ?></span>
                        </div>
                    </div>
                    
                    <div class="deam-event-footer">
                        <span class="deam-event-status <?php echo $status_class; ?>">
                            <?php echo $status; ?>
                        </span>
                        <a href="<?php echo get_permalink(); ?>" class="deam-explore-btn">
                            Explore Event
                        </a>
                    </div>
                </div>
            </div>
            
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <p class="deam-no-events"><?php _e('No events found.', 'deam-events'); ?></p>
<?php endif; ?>

<?php wp_reset_postdata(); ?>