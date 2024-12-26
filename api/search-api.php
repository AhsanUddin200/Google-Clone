<?php
header('Content-Type: application/json');

function generateMockResults($query) {
    // Database with exact items from the trending section
    $database = [
        // Technology Category Items
        [
            "title" => "ChatGPT",
            "category" => "Technology",
            "url" => "https://example.com/chatgpt",
            "description" => "ChatGPT - Advanced AI language model"
        ],
        [
            "title" => "Technology",
            "category" => "Main Category",
            "url" => "https://example.com/technology",
            "description" => "Latest Technology news and updates"
        ],
        
        // Sports Category Items
        [
            "title" => "World Cup 2024",
            "category" => "Sports",
            "url" => "https://example.com/worldcup",
            "description" => "World Cup 2024 updates and matches"
        ],
        [
            "title" => "Sports",
            "category" => "Main Category",
            "url" => "https://example.com/sports",
            "description" => "Sports news and updates"
        ],
        
        // Entertainment Category Items
        [
            "title" => "Taylor Swift new album",
            "category" => "Entertainment",
            "url" => "https://example.com/taylor-swift",
            "description" => "Taylor Swift's latest album updates"
        ],
        [
            "title" => "Entertainment",
            "category" => "Main Category",
            "url" => "https://example.com/entertainment",
            "description" => "Entertainment news and updates"
        ],
        
        // Additional Technology Items
        [
            "title" => "iPhone 15",
            "category" => "Technology",
            "url" => "https://example.com/iphone15",
            "description" => "iPhone 15 features and specifications"
        ],
        
        // News Category Items
        [
            "title" => "Climate change news",
            "category" => "News",
            "url" => "https://example.com/climate-change",
            "description" => "Latest climate change updates"
        ],
        [
            "title" => "News",
            "category" => "Main Category",
            "url" => "https://example.com/news",
            "description" => "Latest news and updates"
        ]
    ];

    // Simple search logic
    $query = strtolower($query);
    $results = array_filter($database, function($item) use ($query) {
        return (
            str_contains(strtolower($item['title']), $query) ||
            str_contains(strtolower($item['category']), $query) ||
            str_contains(strtolower($item['description']), $query)
        );
    });

    return array_values($results);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = isset($_GET['q']) ? trim($_GET['q']) : '';
    
    if (empty($query)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Search query is required'
        ]);
        exit;
    }

    $results = generateMockResults($query);
    
    echo json_encode([
        'status' => 'success',
        'query' => $query,
        'total_results' => count($results),
        'results' => $results
    ]);
}
?> 