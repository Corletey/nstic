<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Statistics Cards</title>
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        
        /* Container for the stat cards */
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            margin: -10px; /* Negative margin to offset the padding of cards */
        }
        
        /* Individual stat card */
        .stat-card {
            flex: 1 0 calc(25% - 20px); /* Default for desktop: 4 cards per row */
            margin: 10px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            min-width: 200px; /* Minimum width to prevent tiny cards */
        }
        
        /* Stat card title */
        .stat-card-title {
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        
        /* Stat value buttons */
        .stat-value {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            min-width: 80px;
        }
        
        /* Button colors */
        .btn {
            background-color: #4CAF50; /* Green */
        }
        
        .btn2 {
            background-color: #2196F3; /* Blue */
        }
        
        .btn3 {
            background-color: #FF9800; /* Orange */
        }
        
        .btn4 {
            background-color: #f44336; /* Red */
        }
        
        /* Responsive breakpoints */
        @media (max-width: 1024px) {
            .stat-card {
                flex: 1 0 calc(33.333% - 20px); /* 3 cards per row on tablets */
            }
        }
        
        @media (max-width: 768px) {
            .stat-card {
                flex: 1 0 calc(50% - 20px); /* 2 cards per row on small tablets */
            }
        }
        
        @media (max-width: 480px) {
            .stat-card {
                flex: 1 0 calc(100% - 20px); /* 1 card per row on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-card-title"><?php echo $lang_Recent_Calls_Active; ?></div>
            <div class="stat-value btn"><?php TotalCalls(); ?></div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-title"><?php echo $lang_Number_Submissions_Received; ?></div>
            <div class="stat-value btn2"><?php NumberofSubmissionsReceived(); ?></div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-title"><?php echo $lang_Grants_Awarded; ?></div>
            <div class="stat-value btn3"><?php GrantsAwarded(); ?></div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-title"><?php echo $lang_Total_Users; ?></div>
            <div class="stat-value btn4"><?php TotalUsers(); ?></div>
        </div>
    </div>
</body>
</html>