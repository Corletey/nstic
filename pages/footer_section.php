<!-- Footer Section with In-document CSS -->
<style>
    /* Footer Styles */
    .footer_top {
        padding: 60px 0;
        color: white;
    }
    
    .footer_single_col h3 {
        color: white;
        margin-bottom: 25px;
        font-weight: 600;
    }
    
    .quick_inf0 {
        list-style: none;
        padding-left: 0;
    }
    
    .quick_inf0 li {
        margin-bottom: 10px;
    }
    
    .quick_inf0 li a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }
    
    .quick_inf0 li a:hover {
        color: #e0e0e0;
        padding-left: 5px;
    }
    
    /* Middle Column Styles */
    .grants-container {
        background-color: rgba(45, 55, 95, 0.8);
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
    }
    
    .about-text {
        color: #d9e3ff;
        line-height: 1.6;
        font-size: 16px;
    }
    
    .learn-more-btn {
        background-color: #5eb060;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .learn-more-btn:hover {
        background-color: #4a9c4d;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .learn-more-btn i {
        margin-right: 8px;
    }
    
    /* Contact Styles */
    .contact-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .contact-info-item i {
        margin-right: 10px;
        color: #5eb060;
    }
    
    .contact-email {
        color: #5eb060; 
        text-decoration: none;
    }
    
    /* Social Icons */
    .social_items li {
        margin-right: 15px;
    }
    
    .social_items a {
        color: white;
        font-size: 18px;
        transition: all 0.3s ease;
    }
    
    .social_items a:hover {
        color: #5eb060;
        transform: translateY(-3px);
        display: inline-block;
    }
</style>

<div class="container">
    <div class="footer_top">
        <div class="row">
            <!-- First Column - Useful Links -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="footer_single_col">
                    <h3>Useful Links</h3>
                    <ul class="quick_inf0">
                        <li><a href="https://uncst.go.ug/"> UNCST</a></li>
                        <li><a href="https://aau.org/"> AAU</a></li>
                        <li><a href="https://sgciafrica.org/"> SGCI</a></li>
                    </ul>                         
                </div>
            </div>
            
            <!-- Styled Middle Column - Grants Management System Info -->
            <div class="col-md-6"> 
                <div class="footer-section text-center"> 
                    <h3>Grants Management System</h3>
                    <div class="grants-container">
                        <p class="about-text"> 
                            The Grants Management System is a comprehensive platform designed to streamline the grant application, review, and award process for research initiatives. 
                        </p> 
                    </div>
                    <a href="#" class="learn-more-btn"> 
                        <i class="fas fa-info-circle"></i> Learn More 
                    </a> 
                </div> 
            </div>

            
            
            <!-- Third Column - Contact Information -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="footer_single_col contact">
                    <h3><?php echo $lang_ContactsUS;?></h3>
                    <p><?php echo $lang_feelFree;?></p>
                    <div class="contact_info">
                        <div class="contact-info-item">
                            <i class="fas fa-phone-alt"></i>
                            <span><?php TopBarTelephoneBottom();?></span>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <span>
                            <?php TopBarEmailBottom();?>
                            </span>
                        </div>
                    </div>
                    <ul class="social_items d-flex list-unstyled mt-4">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Round Shape Elements -->
<div class="round_shape">
    <span class="shape_1"></span> 
    <span class="shape_2"></span> 
    <span class="shape_3"></span> 
    <span class="shape_4"></span> 
    <span class="shape_5"></span> 
    <span class="shape_6"></span>
</div>