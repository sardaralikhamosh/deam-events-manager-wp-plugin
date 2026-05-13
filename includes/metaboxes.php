<?php
// Add metaboxes for event details
add_action('add_meta_boxes', 'deam_events_add_metaboxes');
function deam_events_add_metaboxes() {
    add_meta_box(
        'deam_event_details',
        __('Event Details', 'deam-events'),
        'deam_events_details_metabox',
        'deam_event',
        'normal',
        'high'
    );
    
    add_meta_box(
        'deam_event_gallery',
        __('Event Gallery', 'deam-events'),
        'deam_events_gallery_metabox',
        'deam_event',
        'normal',
        'high'
    );
}

// Event details metabox
function deam_events_details_metabox($post) {
    wp_nonce_field('deam_events_save_data', 'deam_events_meta_nonce');
    
    $location = get_post_meta($post->ID, '_deam_event_location', true);
    $start_date = get_post_meta($post->ID, '_deam_event_start_date', true);
    $end_date = get_post_meta($post->ID, '_deam_event_end_date', true);
    $organizer = get_post_meta($post->ID, '_deam_event_organizer', true);
    ?>
    <div class="deam-metabox-wrapper">
        <p>
            <label for="deam_event_location"><?php _e('Event Location:', 'deam-events'); ?></label>
            <input type="text" id="deam_event_location" name="deam_event_location" value="<?php echo esc_attr($location); ?>" class="widefat" />
        </p>
        <p>
            <label for="deam_event_organizer"><?php _e('Event Organizer:', 'deam-events'); ?></label>
            <input type="text" id="deam_event_organizer" name="deam_event_organizer" value="<?php echo esc_attr($organizer); ?>" class="widefat" />
        </p>
        <p>
            <label for="deam_event_start_date"><?php _e('Start Date:', 'deam-events'); ?></label>
            <input type="datetime-local" id="deam_event_start_date" name="deam_event_start_date" value="<?php echo esc_attr($start_date); ?>" class="widefat" />
        </p>
        <p>
            <label for="deam_event_end_date"><?php _e('End Date:', 'deam-events'); ?></label>
            <input type="datetime-local" id="deam_event_end_date" name="deam_event_end_date" value="<?php echo esc_attr($end_date); ?>" class="widefat" />
        </p>
    </div>
    <?php
}

// Event gallery metabox
function deam_events_gallery_metabox($post) {
    $gallery_images = get_post_meta($post->ID, '_deam_event_gallery', true);
    $gallery_images = $gallery_images ? explode(',', $gallery_images) : array();
    ?>
    <div class="deam-gallery-wrapper">
        <div class="deam-gallery-images">
            <?php foreach ($gallery_images as $image_id): ?>
                <div class="deam-gallery-image">
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <input type="hidden" name="deam_event_gallery[]" value="<?php echo esc_attr($image_id); ?>" />
                    <button type="button" class="button remove-gallery-image"><?php _e('Remove', 'deam-events'); ?></button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button" id="deam_add_gallery_images"><?php _e('Add Images to Gallery', 'deam-events'); ?></button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#deam_add_gallery_images').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Select Gallery Images',
                multiple: true,
                library: { type: 'image' },
                button: { text: 'Add to Gallery' }
            });
            
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                selection.each(function(attachment) {
                    var imageId = attachment.id;
                    var imageUrl = attachment.attributes.url;
                    var thumbnailUrl = attachment.attributes.sizes.thumbnail ? attachment.attributes.sizes.thumbnail.url : imageUrl;
                    
                    var imageHtml = '<div class="deam-gallery-image">' +
                        '<img src="' + thumbnailUrl + '" />' +
                        '<input type="hidden" name="deam_event_gallery[]" value="' + imageId + '" />' +
                        '<button type="button" class="button remove-gallery-image">Remove</button>' +
                        '</div>';
                    
                    $('.deam-gallery-images').append(imageHtml);
                });
            });
            
            frame.open();
        });
        
        $(document).on('click', '.remove-gallery-image', function() {
            $(this).closest('.deam-gallery-image').remove();
        });
    });
    </script>
    <?php
}

// Save metabox data
add_action('save_post', 'deam_events_save_metabox_data');
function deam_events_save_metabox_data($post_id) {
    if (!isset($_POST['deam_events_meta_nonce']) || !wp_verify_nonce($_POST['deam_events_meta_nonce'], 'deam_events_save_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['deam_event_location'])) {
        update_post_meta($post_id, '_deam_event_location', sanitize_text_field($_POST['deam_event_location']));
    }
    
    if (isset($_POST['deam_event_organizer'])) {
        update_post_meta($post_id, '_deam_event_organizer', sanitize_text_field($_POST['deam_event_organizer']));
    }
    
    if (isset($_POST['deam_event_start_date'])) {
        update_post_meta($post_id, '_deam_event_start_date', sanitize_text_field($_POST['deam_event_start_date']));
    }
    
    if (isset($_POST['deam_event_end_date'])) {
        update_post_meta($post_id, '_deam_event_end_date', sanitize_text_field($_POST['deam_event_end_date']));
    }
    
    if (isset($_POST['deam_event_gallery']) && is_array($_POST['deam_event_gallery'])) {
        $gallery_ids = array_map('intval', $_POST['deam_event_gallery']);
        update_post_meta($post_id, '_deam_event_gallery', implode(',', $gallery_ids));
    } else {
        delete_post_meta($post_id, '_deam_event_gallery');
    }
}

// Enqueue media uploader for gallery
add_action('admin_enqueue_scripts', 'deam_events_admin_scripts');
function deam_events_admin_scripts($hook) {
    global $post;
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post && $post->post_type == 'deam_event') {
            wp_enqueue_media();
            wp_enqueue_script('jquery');
        }
    }
}