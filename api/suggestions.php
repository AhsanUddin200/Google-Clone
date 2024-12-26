<?php
header('Content-Type: application/json');

function getSuggestions($query) {
    // Predefined suggestions based on our database
    $allSuggestions = [
        'chatgpt' => [
            'chatgpt how to use',
            'chatgpt api',
            'chatgpt alternatives',
            'chatgpt for developers'
        ],
        'world cup' => [
            'world cup 2024 schedule',
            'world cup teams',
            'world cup tickets',
            'world cup standings'
        ],
        'taylor swift' => [
            'taylor swift new album',
            'taylor swift tour dates',
            'taylor swift songs',
            'taylor swift concert tickets'
        ],
        'iphone' => [
            'iphone 15 price',
            'iphone 15 vs 14',
            'iphone 15 features',
            'iphone 15 release date'
        ],
        'climate' => [
            'climate change news',
            'climate change effects',
            'climate change solutions',
            'climate change 2024'
        ]
    ];

    // Find matching suggestions
    $suggestions = [];
    foreach ($allSuggestions as $key => $values) {
        if (stripos($key, $query) !== false) {
            $suggestions = array_merge($suggestions, $values);
        }
    }

    // Also add exact query if it's not in suggestions
    if (!in_array($query, $suggestions)) {
        array_unshift($suggestions, $query);
    }

    return array_slice($suggestions, 0, 5); // Return max 5 suggestions
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = isset($_GET['q']) ? trim($_GET['q']) : '';
    
    if (strlen($query) < 2) {
        echo json_encode([]);
        exit;
    }

    $suggestions = getSuggestions($query);
    echo json_encode($suggestions);
}
?> 