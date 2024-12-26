<?php
// Start session if needed
session_start();

// Get the article ID from URL
$article_id = isset($_GET['id']) ? $_GET['id'] : '';

// Initialize article variable
$article = null;

// Define your dummy data array (you can move this to a separate file)
$dummy_data = [
    [
        "title" => "Learn PHP: The Basics of Server-Side Scripting",
        "description" => "An introductory guide to PHP programming for beginners.",
        "link" => "https://example.com/learn-php",
        "full_content" => "PHP is one of the most popular server-side scripting languages for web development. 
                          This comprehensive guide will walk you through the fundamentals of PHP programming.

                          Topics covered:
                          - Setting up your PHP environment
                          - Variables and data types
                          - Control structures
                          - Functions and arrays
                          - Working with forms
                          - Database connectivity",
        "author" => "John Doe",
        "date_published" => "2024-01-15"
    ],
    [
        "title" => "CSS Styling Techniques for Modern Web Design",
        "description" => "Enhance your web pages with advanced CSS styling methods.",
        "link" => "https://example.com/css-styling",
        "full_content" => "Master modern CSS techniques to create beautiful and responsive websites. 
                          This guide covers everything from basics to advanced concepts.

                          Topics covered:
                          - Flexbox and Grid layouts
                          - CSS Variables
                          - Animations and transitions
                          - Responsive design
                          - CSS preprocessors
                          - Modern CSS frameworks",
        "author" => "Sarah Smith",
        "date_published" => "2024-02-01"
    ],
    [
        "title" => "JavaScript Essentials: From Fundamentals to Advanced Concepts",
        "description" => "Master JavaScript to create dynamic and interactive web applications.",
        "link" => "https://example.com/javascript-essentials",
        "full_content" => "Learn JavaScript from the ground up and master the language that powers the modern web.

                          Key Topics:
                          - Core JavaScript concepts
                          - DOM manipulation
                          - Event handling
                          - Async programming
                          - Modern ES6+ features
                          - Popular frameworks overview",
        "author" => "Mike Johnson",
        "date_published" => "2024-02-15"
    ],
    [
        "title" => "Building Responsive Websites with HTML5 and CSS3",
        "description" => "Create mobile-friendly and responsive websites using the latest web technologies.",
        "link" => "https://example.com/responsive-websites",
        "full_content" => "Learn how to build modern, responsive websites that work seamlessly across all devices.

                          Course Content:
                          - HTML5 semantic elements
                          - Responsive design principles
                          - Media queries
                          - Mobile-first approach
                          - Performance optimization
                          - Testing across devices",
        "author" => "Lisa Chen",
        "date_published" => "2024-03-01"
    ],
    [
        "title" => "Backend Development with PHP and MySQL",
        "description" => "Develop robust backend systems using PHP and MySQL databases.",
        "link" => "https://example.com/php-mysql-backend",
        "full_content" => "Master backend development by combining PHP with MySQL to create powerful web applications.

                          Topics covered:
                          - Database design
                          - CRUD operations
                          - Authentication systems
                          - API development
                          - Security best practices
                          - Performance optimization",
        "author" => "David Wilson",
        "date_published" => "2024-03-15"
    ],
    [
        "title" => "ChatGPT: Complete Guide 2024",
        "description" => "Everything you need to know about ChatGPT, the revolutionary AI chatbot.",
        "link" => "https://example.com/chatgpt",
        "full_content" => "Explore the capabilities and applications of ChatGPT in this comprehensive guide.

                          Guide Contents:
                          - What is ChatGPT?
                          - How to use ChatGPT effectively
                          - Business applications
                          - Integration methods
                          - Best practices
                          - Future of AI chatbots",
        "author" => "AI Research Team",
        "date_published" => "2024-01-20"
    ],
    [
        "title" => "iPhone 15: Features, Specs, and Reviews",
        "description" => "Comprehensive review of Apple's iPhone 15 including new features and improvements.",
        "link" => "https://example.com/iphone-15",
        "full_content" => "A detailed look at Apple's latest flagship smartphone, the iPhone 15 series. 
                          This comprehensive review covers everything you need to know before making your purchase.

                          Models Available:
                          - iPhone 15
                          - iPhone 15 Plus
                          - iPhone 15 Pro
                          - iPhone 15 Pro Max

                          Key Features:
                          - Dynamic Island on all models
                          - USB-C Port Implementation
                          - A17 Pro Chip (Pro models)
                          - A16 Chip (standard models)
                          - Improved Camera System
                          
                          Display Specifications:
                          - Pro Max: 6.7-inch OLED
                          - Pro: 6.1-inch OLED
                          - Plus: 6.7-inch OLED
                          - Standard: 6.1-inch OLED
                          - ProMotion Technology
                          - Always-On Display (Pro models)
                          
                          Camera Capabilities:
                          - 48MP Main Camera
                          - Enhanced Telephoto Lens
                          - Improved Night Mode
                          - Advanced Portrait Mode
                          - 4K Video at 60fps
                          - Cinematic Mode Updates
                          
                          Battery Life:
                          - Up to 29 hours video playback
                          - Fast charging capability
                          - MagSafe charging support
                          - Wireless charging
                          
                          Performance:
                          - Gaming Capabilities
                          - App Loading Times
                          - Multitasking Performance
                          - Thermal Management
                          
                          Design Changes:
                          - Titanium Frame (Pro models)
                          - Color Options
                          - Weight Reduction
                          - Durability Improvements
                          
                          Software Features:
                          - iOS 17 Integration
                          - New Security Features
                          - StandBy Mode
                          - NameDrop
                          - Enhanced Privacy Controls
                          
                          Price Breakdown:
                          - iPhone 15: Starting $799
                          - iPhone 15 Plus: Starting $899
                          - iPhone 15 Pro: Starting $999
                          - iPhone 15 Pro Max: Starting $1199
                          
                          Expert Verdict:
                          The iPhone 15 series represents a significant step forward in Apple's 
                          smartphone evolution. The addition of USB-C, improved cameras, and 
                          powerful processors make it a compelling upgrade for many users.
                          
                          Pros:
                          - USB-C Universal Compatibility
                          - Improved Camera System
                          - Powerful Performance
                          - Better Battery Life
                          
                          Cons:
                          - Premium Pricing
                          - Limited Base Storage
                          - Charging Speed Could Be Better
                          
                          Final Rating: 4.5/5 stars",
        "author" => "Tech Review Team",
        "date_published" => "2024-02-20",
        "category" => "Technology"
    ],
    // ... continue with the rest of the articles from search.php ...
];

// Find the matching article
foreach ($dummy_data as $item) {
    if ($item['link'] === $article_id) {
        $article = $item;
        break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $article ? htmlspecialchars($article['title']) : 'Article Not Found'; ?></title>
    <style>
        body {
            background-color: #202124;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .article-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #303134;
            border-radius: 8px;
        }

        .article-title {
            color: #8ab4f8;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .article-meta {
            color: #9aa0a6;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .article-content {
            color: #e8eaed;
            line-height: 1.6;
        }

        .back-button {
            display: inline-block;
            padding: 8px 16px;
            background: #8ab4f8;
            color: #202124;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: #aecbfa;
        }

        .not-found {
            text-align: center;
            padding: 50px;
            color: #e8eaed;
        }
    </style>
</head>
<body>
    <a href="search.php" class="back-button">← Back to Search</a>

    <?php if ($article): ?>
        <div class="article-container">
            <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>
            
            <div class="article-meta">
                By <?php echo htmlspecialchars($article['author']); ?> | 
                Published on <?php echo htmlspecialchars($article['date_published']); ?>
            </div>
            
            <div class="article-content">
                <?php echo nl2br(htmlspecialchars($article['full_content'])); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="not-found">
            <h2>Article Not Found</h2>
            <p>Sorry, the requested article could not be found.</p>
        </div>
    <?php endif; ?>
</body>
</html> 