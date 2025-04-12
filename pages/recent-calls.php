<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Calls</title>
    <style>
    /* Recent Calls Section */
.events-area {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.col-12 {
    width: 100%;
    padding: 0 15px;
}

.sub_title {
    text-align: center;
    margin-bottom: 40px;
}

.sub_title h2 {
    position: relative;
    display: inline-block;
    font-size: 32px;
    font-weight: 700;
    color: #333;
    padding-bottom: 15px;
    margin-bottom: 0;
}

.sub_title h2:after {
    content: '';
    position: absolute;
    width: 50%;
    height: 3px;
    background-color: #f58f14;
    bottom: 0;
    left: 25%;
}

/* Grid layout for cards */
.recent-calls-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Default to 3 columns */
    gap: 20px;
    width: 100%;
    margin-bottom: 30px;
}

/* Card design */
.call-card {
    position: relative;
    display: flex;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.call-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

/* Date badge */
.call-date {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-width: 80px;
    background-color: #f58f14;
    color: #fff;
    padding: 15px 10px;
    text-align: center;
}

.date-day {
    font-size: 24px;
    font-weight: 700;
    line-height: 1;
}

.date-month {
    font-size: 16px;
    text-transform: uppercase;
    margin-top: 5px;
}

/* Card content */
.call-content {
    padding: 20px;
    flex-grow: 1;
}

.call-title {
    font-size: 18px;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 15px;
}

.call-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.2s ease;
}

.call-title a:hover {
    color: #f58f14;
}

/* Meta information */
.call-meta {
    margin-bottom: 15px;
}

.deadline {
    display: flex;
    align-items: center;
    color: #666;
    font-size: 14px;
}

.deadline i {
    margin-right: 8px;
    color: #f58f14;
}

/* Call to action */
.call-action {
    margin-top: 15px;
}

.view-details-btn {
    display: inline-block;
    background-color: #0066cc;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 8px 20px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.view-details-btn:hover {
    background-color: #0052a3;
    color: #fff;
}

/* View All Button */
.view-all-container {
    text-align: center;
    margin-top: 20px;
}

.view-all-btn {
    display: inline-block;
    background-color: #f58f14;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    padding: 12px 30px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.view-all-btn:hover {
    background-color: #e07c00;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.view-all-btn i {
    margin-left: 5px;
}

.call-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 15px;
}

.button-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.view-details-btn {
    display: inline-block;
    background-color: #0066cc;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.view-details-btn:hover {
    background-color: #0052a3;
    color: #fff;
}

.apply-btn {
    display: inline-block;
    background-color: #f58f14;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.apply-btn:hover {
    background-color: #e07c00;
    color: #fff;
}

@media (max-width: 480px) {
    .button-group {
        flex-direction: column;
    }
    
    .view-details-btn, .apply-btn {
        display: block;
        text-align: center;
    }
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .recent-calls-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for tablets */
    }
}

@media (max-width: 767px) {
    .events-area {
        padding: 40px 0;
    }
    
    .sub_title h2 {
        font-size: 28px;
    }
    
    .recent-calls-grid {
        grid-template-columns: 1fr; /* 1 column for mobile devices */
        max-width: 500px;
        margin: 0 auto 30px;
    }
}

@media (max-width: 480px) {
    .call-card {
        flex-direction: column;
    }
    
    .call-date {
        flex-direction: row;
        width: 100%;
        padding: 10px;
        justify-content: center;
    }
    
    .date-day {
        font-size: 20px;
        margin-right: 5px;
    }
    
    .date-month {
        font-size: 14px;
        margin-top: 0;
    }
    
    .call-title {
        font-size: 16px;
    }
    
    .view-details-btn {
        display: block;
        text-align: center;
    }

    .view-all-btn {
        width: 100%;
        max-width: 280px;
    }
}
    </style>
</head>
<body>
<section class="events-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sub_title">
                    <h2><?php echo $lang_Recent_Calls_Active; ?></h2>
                </div>
                
                <?php RecentCalls(); ?>
                
                <div class="view-all-container">
                    <a href="all-grants.php" class="view-all-btn">
                        <?php echo $lang_View_All_Grants ?? 'View All Grants'; ?> <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>