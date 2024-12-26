<?php
header('Content-Type: application/json');

function getTrendingSearches() {
    // Exact same trending items as shown in the image
    return [
        [
            "query" => "ChatGPT",
            "category" => "Technology"
        ],
        [
            "query" => "World Cup 2024",
            "category" => "Sports"
        ],
        [
            "query" => "Taylor Swift new album",
            "category" => "Entertainment"
        ],
        [
            "query" => "iPhone 15",
            "category" => "Technology"
        ],
        [
            "query" => "Climate change news",
            "category" => "News"
        ]
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        'status' => 'success',
        'trending' => getTrendingSearches()
    ]);
}
?> 