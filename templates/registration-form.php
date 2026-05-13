<?php
/**
 * Professional Registration Form Template
 * Pixel-perfect, responsive design with success popup
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get event ID from parameter or global variable
$event_id = isset($event_id) ? $event_id : (isset($GLOBALS['current_event_id']) ? $GLOBALS['current_event_id'] : 0);
$event_title = get_the_title($event_id);
?>

<!-- Registration Modal -->
<div id="deam-registration-modal" class="deam-modal">
    <div class="deam-modal-container">
        <div class="deam-modal-header">
            <button type="button" class="deam-modal-close">&times;</button>
            <div class="deam-modal-icon">📋</div>
            <h2 class="deam-modal-title">Register for <span class="deam-event-highlight"><?php echo esc_html($event_title); ?></span></h2>
            <p class="deam-modal-subtitle">Please fill out the form below to secure your spot</p>
        </div>
        
        <form id="deam-registration-form" class="deam-registration-form" method="post">
            <input type="hidden" name="event_id" value="<?php echo esc_attr($event_id); ?>">
            
            <div class="deam-form-row">
                <div class="deam-form-group">
                    <label class="deam-form-label">
                        Full Name <span class="deam-required">*</span>
                    </label>
                    <input type="text" 
                           class="deam-form-input" 
                           id="reg_name" 
                           name="name" 
                           placeholder="Enter your full name"
                           required>
                </div>
            </div>
            
            <div class="deam-form-row deam-form-row-two-col">
                <div class="deam-form-group">
                    <label class="deam-form-label">
                        Contact Number <span class="deam-required">*</span>
                    </label>
                    <input type="tel" 
                           class="deam-form-input" 
                           id="reg_contact" 
                           name="contact_number" 
                           placeholder="+1234567890"
                           required>
                </div>
                
                <div class="deam-form-group">
                    <label class="deam-form-label">
                        Email Address <span class="deam-required">*</span>
                    </label>
                    <input type="email" 
                           class="deam-form-input" 
                           id="reg_email" 
                           name="email" 
                           placeholder="your@email.com"
                           required>
                </div>
            </div>
            
            <div class="deam-form-row">
                <div class="deam-form-group">
                    <label class="deam-form-label">
                        Address <span class="deam-required">*</span>
                    </label>
                    <textarea class="deam-form-textarea" 
                              id="reg_address" 
                              name="address" 
                              rows="3" 
                              placeholder="Your complete address"
                              required></textarea>
                </div>
            </div>
            
            <div class="deam-form-row deam-form-row-two-col">
                <div class="deam-form-group">
                    <label class="deam-form-label">
                        Nationality <span class="deam-required">*</span>
                    </label>
                    <input type="text" 
                           class="deam-form-input" 
                           id="reg_nationality" 
                           name="nationality" 
                           placeholder="Your nationality"
                           required>
                </div>
                
                <div class="deam-form-group">
                    <label class="deam-form-label">
                        Gender <span class="deam-required">*</span>
                    </label>
                    <div class="deam-radio-wrapper">
                        <label class="deam-radio-label">
                            <input type="radio" name="gender" value="Male" required>
                            <span class="deam-radio-custom"></span>
                            Male
                        </label>
                        <label class="deam-radio-label">
                            <input type="radio" name="gender" value="Female">
                            <span class="deam-radio-custom"></span>
                            Female
                        </label>
                        <label class="deam-radio-label">
                            <input type="radio" name="gender" value="Other">
                            <span class="deam-radio-custom"></span>
                            Other
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="deam-form-row">
                <label class="deam-checkbox-label">
                    <input type="checkbox" id="reg_terms" required>
                    <span class="deam-checkbox-custom"></span>
                    I agree to the <a href="#" class="deam-terms-link">terms and conditions</a> <span class="deam-required">*</span>
                </label>
            </div>
            
            <div class="deam-form-row">
                <button type="submit" class="deam-submit-btn" id="deam-submit-btn">
                    <span class="deam-btn-text">Submit Registration</span>
                    <span class="deam-btn-loader" style="display: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" fill="none" stroke-dasharray="31.4 31.4">
                                <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                            </circle>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success Popup (Hidden initially) -->
<div id="deam-success-popup" class="deam-success-popup" style="display: none;">
    <div class="deam-success-popup-overlay"></div>
    <div class="deam-success-popup-container">
        <div class="deam-success-popup-content">
            <div class="deam-success-icon">✓</div>
            <h3 class="deam-success-title">Registration Successful!</h3>
            <p class="deam-success-message">
                Your registration has been successfully submitted. You will receive a confirmation email within 3 working days.
            </p>
            <button type="button" class="deam-success-close-btn">Close</button>
        </div>
    </div>
</div>

<style>
/* Professional Registration Form Styles */
.deam-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(4px);
    overflow-y: auto;
}

.deam-modal-container {
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    margin: 40px auto;
    max-width: 680px;
    width: 90%;
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: deamModalFadeIn 0.3s ease-out;
}

@keyframes deamModalFadeIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.deam-modal-header {
    text-align: center;
    padding: 32px 32px 24px;
    border-bottom: 1px solid #e2e8f0;
    position: relative;
}

.deam-modal-close {
    position: absolute;
    right: 20px;
    top: 20px;
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    color: #94a3b8;
    transition: all 0.2s;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.deam-modal-close:hover {
    color: #ef4444;
    background: #fef2f2;
}

.deam-modal-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.deam-modal-title {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 8px 0;
    font-family: 'Poppins', sans-serif;
}

.deam-event-highlight {
    color: #f68511;
    position: relative;
    display: inline-block;
}

.deam-event-highlight::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f68511, #0048a5);
    border-radius: 2px;
}

.deam-modal-subtitle {
    color: #64748b;
    font-size: 14px;
    margin: 0;
}

/* Form Styles */
.deam-registration-form {
    padding: 32px;
}

.deam-form-row {
    margin-bottom: 24px;
}

.deam-form-row-two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.deam-form-group {
    width: 100%;
}

.deam-form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
    font-family: 'Poppins', sans-serif;
}

.deam-required {
    color: #f68511;
    font-weight: 700;
    margin-left: 2px;
}

.deam-form-input,
.deam-form-textarea {
    width: 100%;
    padding: 12px 16px;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    background: white;
    transition: all 0.2s;
    box-sizing: border-box;
}

.deam-form-input:focus,
.deam-form-textarea:focus {
    outline: none;
    border-color: #f68511;
    box-shadow: 0 0 0 3px rgba(246, 133, 17, 0.1);
}

.deam-form-input:hover,
.deam-form-textarea:hover {
    border-color: #cbd5e1;
}

/* Radio Buttons */
.deam-radio-wrapper {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    padding: 8px 0;
}

.deam-radio-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
}

.deam-radio-label input[type="radio"] {
    display: none;
}

.deam-radio-custom {
    width: 18px;
    height: 18px;
    border: 2px solid #cbd5e1;
    border-radius: 50%;
    display: inline-block;
    position: relative;
    transition: all 0.2s;
}

.deam-radio-label input[type="radio"]:checked + .deam-radio-custom {
    border-color: #f68511;
    background: #f68511;
    box-shadow: inset 0 0 0 3px white;
}

.deam-radio-label:hover .deam-radio-custom {
    border-color: #f68511;
}

/* Checkbox */
.deam-checkbox-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
}

.deam-checkbox-label input[type="checkbox"] {
    display: none;
}

.deam-checkbox-custom {
    width: 20px;
    height: 20px;
    border: 2px solid #cbd5e1;
    border-radius: 6px;
    display: inline-block;
    position: relative;
    transition: all 0.2s;
}

.deam-checkbox-label input[type="checkbox"]:checked + .deam-checkbox-custom {
    background: #f68511;
    border-color: #f68511;
}

.deam-checkbox-label input[type="checkbox"]:checked + .deam-checkbox-custom::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.deam-terms-link {
    color: #f68511;
    text-decoration: none;
    font-weight: 600;
}

.deam-terms-link:hover {
    color: #0048a5;
    text-decoration: underline;
}

/* Submit Button */
.deam-submit-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #f68511 0%, #e0760e 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.deam-submit-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(246, 133, 17, 0.4);
}

.deam-submit-btn:active:not(:disabled) {
    transform: translateY(0);
}

.deam-submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.deam-btn-loader {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* Success Popup */
.deam-success-popup {
    position: fixed;
    z-index: 10001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.deam-success-popup-overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(8px);
}

.deam-success-popup-container {
    position: relative;
    background: white;
    max-width: 450px;
    width: 90%;
    border-radius: 32px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    animation: deamSuccessSlideIn 0.4s ease-out;
    z-index: 1;
}

@keyframes deamSuccessSlideIn {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.deam-success-popup-content {
    padding: 48px 32px;
    text-align: center;
}

.deam-success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    font-size: 48px;
    color: white;
    font-weight: 700;
    animation: deamSuccessCheck 0.5s ease-out;
}

@keyframes deamSuccessCheck {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}

.deam-success-title {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 16px 0;
    font-family: 'Poppins', sans-serif;
}

.deam-success-message {
    font-size: 16px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 32px;
}

.deam-success-close-btn {
    background: linear-gradient(135deg, #f68511 0%, #e0760e 100%);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 40px;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
}

.deam-success-close-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px -5px rgba(246, 133, 17, 0.4);
}

/* Error message styling */
.deam-form-error {
    color: #ef4444;
    font-size: 12px;
    margin-top: 6px;
    display: block;
}

/* Responsive Design */
@media (max-width: 640px) {
    .deam-modal-container {
        width: 95%;
        margin: 20px auto;
        border-radius: 20px;
    }
    
    .deam-modal-header {
        padding: 24px 20px 16px;
    }
    
    .deam-modal-title {
        font-size: 22px;
    }
    
    .deam-modal-icon {
        font-size: 36px;
    }
    
    .deam-registration-form {
        padding: 24px 20px;
    }
    
    .deam-form-row-two-col {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .deam-radio-wrapper {
        gap: 16px;
    }
    
    .deam-success-title {
        font-size: 24px;
    }
    
    .deam-success-popup-content {
        padding: 32px 24px;
    }
    
    .deam-success-icon {
        width: 64px;
        height: 64px;
        font-size: 36px;
    }
}

@media (max-width: 480px) {
    .deam-modal-title {
        font-size: 20px;
    }
    
    .deam-radio-wrapper {
        flex-direction: column;
        gap: 12px;
    }
    
    .deam-submit-btn {
        padding: 14px;
        font-size: 15px;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    var modal = $('#deam-registration-modal');
    var successPopup = $('#deam-success-popup');
    var closeModalBtn = $('.deam-modal-close');
    var closeSuccessBtn = $('.deam-success-close-btn');
    
    // Open modal function
    window.openRegistrationModal = function(eventId) {
        $('#deam-registration-form input[name="event_id"]').val(eventId);
        modal.fadeIn(200);
        $('body').css('overflow', 'hidden');
    };
    
    // Close modal
    closeModalBtn.on('click', function() {
        modal.fadeOut(200);
        $('body').css('overflow', 'auto');
        $('#deam-registration-form')[0].reset();
    });
    
    // Close success popup
    closeSuccessBtn.on('click', function() {
        successPopup.fadeOut(200);
        $('body').css('overflow', 'auto');
        // Also close the modal if it's open
        modal.fadeOut(200);
    });
    
    // Close when clicking outside modal
    $(window).on('click', function(event) {
        if ($(event.target).is('.deam-modal')) {
            modal.fadeOut(200);
            $('body').css('overflow', 'auto');
            $('#deam-registration-form')[0].reset();
        }
        if ($(event.target).is('.deam-success-popup-overlay')) {
            successPopup.fadeOut(200);
            $('body').css('overflow', 'auto');
        }
    });
    
    // Handle form submission
    $('#deam-registration-form').on('submit', function(e) {
        e.preventDefault();
        
        // Validate terms checkbox
        if (!$('#reg_terms').is(':checked')) {
            showErrorMessage('Please accept the terms and conditions to continue.');
            return false;
        }
        
        var formData = $(this).serialize();
        formData += '&action=deam_events_register&nonce=' + deam_events_ajax.nonce;
        
        var submitBtn = $('#deam-submit-btn');
        var btnText = submitBtn.find('.deam-btn-text');
        var btnLoader = submitBtn.find('.deam-btn-loader');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        btnText.hide();
        btnLoader.show();
        
        $.ajax({
            url: deam_events_ajax.ajax_url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    modal.fadeOut(200);
                    
                    // Reset form
                    $('#deam-registration-form')[0].reset();
                    
                    // Show success popup
                    successPopup.fadeIn(200);
                    
                    // Auto close success popup after 5 seconds
                    setTimeout(function() {
                        successPopup.fadeOut(200);
                        $('body').css('overflow', 'auto');
                    }, 5000);
                } else {
                    showErrorMessage(response.data);
                }
            },
            error: function() {
                showErrorMessage('An error occurred. Please try again or contact support.');
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false);
                btnText.show();
                btnLoader.hide();
            }
        });
    });
    
    // Helper function to show error messages
    function showErrorMessage(message) {
        // Remove any existing error messages
        $('#deam-form-error-message').remove();
        
        var errorDiv = $('<div id="deam-form-error-message" class="deam-form-error" style="background: #fef2f2; color: #ef4444; padding: 12px; border-radius: 12px; margin-top: 16px; text-align: center; font-size: 14px;">' + message + '</div>');
        $('#deam-registration-form').append(errorDiv);
        
        // Scroll to error message
        $('html, body').animate({
            scrollTop: errorDiv.offset().top - 100
        }, 300);
        
        // Remove error after 5 seconds
        setTimeout(function() {
            errorDiv.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
});
</script>