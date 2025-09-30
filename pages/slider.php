<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Slider with Error Messages</title>
    <style>
        /* Base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', 'Rubik', sans-serif;
            line-height: 1.6;
        }
        
        /* Error message styles */
        .error-container {
            background: rgb(255, 90, 44);
            text-align: center;
            color: #FFF;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            width: 100%;
        }
        
        .error-container p {
            margin: 0;
            font-size: 16px;
        }
        
        .error-container a {
            color: #fff;
            text-decoration: underline;
            font-weight: bold;
        }
        
        /* Slider container */
        .rev_slider_wrapper {
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        
        /* Make Revolution Slider responsive */
        #rev_slider_1 {
            width: 100% !important;
            height: auto !important;
        }
        
        /* Adjust slider text and buttons for different screen sizes */
        @media only screen and (max-width: 1199px) {
            .tp-caption.font-lora {
                font-size: 36px !important;
            }
            
            .tp-caption.NotGeneric-Title {
                font-size: 90px !important;
            }
            
            .tp-caption.rev-btn {
                font-size: 12px !important;
                padding: 10px 30px !important;
            }
        }
        
        @media only screen and (max-width: 991px) {
            .tp-caption.font-lora {
                font-size: 30px !important;
            }
            
            .tp-caption.NotGeneric-Title {
                font-size: 70px !important;
            }
            
            .tp-caption.rev-btn {
                font-size: 11px !important;
                padding: 8px 25px !important;
            }
        }
        
        @media only screen and (max-width: 767px) {
            .error-container p {
                font-size: 14px;
            }
            
            .tp-caption.font-lora {
                font-size: 24px !important;
                margin-top: 20px !important;
            }
            
            .tp-caption.NotGeneric-Title {
                font-size: 50px !important;
            }
            
            .tp-caption.rev-btn {
                font-size: 10px !important;
                padding: 6px 20px !important;
            }
        }
        
        @media only screen and (max-width: 575px) {
            .error-container {
                padding: 10px;
            }
            
            .error-container p {
                font-size: 12px;
            }
            
            .tp-caption.font-lora {
                font-size: 18px !important;
            }
            
            .tp-caption.NotGeneric-Title {
                font-size: 36px !important;
            }
            
            .tp-caption.rev-btn {
                font-size: 9px !important;
                padding: 5px 15px !important;
            }
        }
    </style>
</head>
<body>
    <!-- Error message containers -->
    <?php if (isset($err2) and $_POST['doLogin']) { ?>
    <div class="error-container">
        <?php echo $lang_wrong_username; ?>
    </div>
    <?php } ?>
    
    <?php if (isset($errormessage) and $_POST['doRegister']) { ?>
    <div class="error-container">
        <p class="error3">
            <?php echo $lang_username_withemail . ' ' . $email; ?> 
            <a href="#" class="nav-link join_now js-modal-show"><?php echo $lang_ClickheretoLogin; ?></a>
        </p>
    </div>
    <?php } ?>
    
    <?php if (isset($message) and $_POST['doRegister']) { ?>
    <div class="error-container" style="background-color: #4CAF50;">
        <?php echo $message; ?>
    </div>
    <?php } ?>
    
    <!-- Slider container -->
    <div class="rev_slider_wrapper">
        <div id="rev_slider_1" class="rev_slider">
            <ul>
                <?php Slider(); ?>
            </ul><!-- END SLIDES LIST -->
        </div><!-- END SLIDER CONTAINER -->
    </div>

    <!-- Additional JavaScript for Revolution Slider responsiveness -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // If RevSlider is initialized globally (assuming jQuery is available)
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.revolution !== 'undefined') {
                jQuery(document).ready(function() {
                    // Reinitialize RevSlider with responsive settings
                    jQuery('#rev_slider_1').show().revolution({
                        responsiveLevels: [1240, 1024, 778, 480],
                        gridwidth: [1240, 1024, 778, 480],
                        gridheight: [700, 600, 500, 400],
                        sliderLayout: 'auto',
                        minHeight: '300',
                        autoHeight: 'on'
                    });
                });
            }
        });
    </script>
</body>
</html>