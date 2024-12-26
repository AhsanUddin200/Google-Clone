<?php
// search.php

// Start session to manage user state (optional, remove if not using sessions)
session_start();

// Initialize variables
$search_query = "";
$search_results = [];
$error_message = "";

// Define the number of results per page
$results_per_page = 5;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    // Retrieve and sanitize the search query
    $search_query = htmlspecialchars(trim($_GET['query']));

    if (!empty($search_query)) {
        // Example dummy data array
        $dummy_data = [
            [
                "title" => "Learn PHP: The Basics of Server-Side Scripting",
                "description" => "An introductory guide to PHP programming for beginners.",
                "link" => "https://example.com/learn-php"
            ],
            [
                "title" => "CSS Styling Techniques for Modern Web Design",
                "description" => "Enhance your web pages with advanced CSS styling methods.",
                "link" => "https://example.com/css-styling"
            ],
            [
                "title" => "JavaScript Essentials: From Fundamentals to Advanced Concepts",
                "description" => "Master JavaScript to create dynamic and interactive web applications.",
                "link" => "https://example.com/javascript-essentials"
            ],
            [
                "title" => "Building Responsive Websites with HTML5 and CSS3",
                "description" => "Create mobile-friendly and responsive websites using the latest web technologies.",
                "link" => "https://example.com/responsive-websites"
            ],
            [
                "title" => "Backend Development with PHP and MySQL",
                "description" => "Develop robust backend systems using PHP and MySQL databases.",
                "link" => "https://example.com/php-mysql-backend"
            ],
            [
                "title" => "ChatGPT: Complete Guide 2024",
                "description" => "Everything you need to know about ChatGPT, the revolutionary AI chatbot.",
                "link" => "https://example.com/chatgpt",
                "category" => "Technology"
            ],
            [
                "title" => "World Cup 2024: Teams, Schedule, and Predictions",
                "description" => "Complete coverage of World Cup 2024 including match schedules and team analysis.",
                "link" => "https://example.com/world-cup-2024",
                "category" => "Sports"
            ],
            [
                "title" => "Taylor Swift New Album: Release Date and Track List",
                "description" => "Get all the details about Taylor Swift's latest album release.",
                "link" => "https://example.com/taylor-swift-album",
                "category" => "Entertainment"
            ],
            [
                "title" => "iPhone 15: Features, Specs, and Reviews",
                "description" => "Comprehensive review of Apple's iPhone 15 including new features and improvements.",
                "link" => "https://example.com/iphone-15",
                "category" => "Technology"
            ],
            [
                "title" => "Climate Change News: Latest Updates",
                "description" => "Recent developments and breaking news about climate change and environmental issues.",
                "link" => "https://example.com/climate-change",
                "category" => "News"
            ],
            
            // Adding category pages
            [
                "title" => "Technology News and Updates",
                "description" => "Latest technology trends, news, and innovations.",
                "link" => "https://example.com/technology",
                "category" => "Technology"
            ],
            [
                "title" => "Sports Coverage and Updates",
                "description" => "Complete sports coverage including latest news and events.",
                "link" => "https://example.com/sports",
                "category" => "Sports"
            ],
            [
                "title" => "Entertainment News",
                "description" => "Latest updates from the entertainment world.",
                "link" => "https://example.com/entertainment",
                "category" => "Entertainment"
            ],
            [
                "title" => "News Headlines",
                "description" => "Breaking news and latest updates from around the world.",
                "link" => "https://example.com/news",
                "category" => "News"
            ]
        ];

        // Simple search simulation: filter dummy data based on the query
        foreach ($dummy_data as $item) {
            if (stripos($item['title'], $search_query) !== false || stripos($item['description'], $search_query) !== false) {
                // Highlight the search term in the title and description
                $highlighted_title = preg_replace("/(" . preg_quote($search_query, '/') . ")/i", "<mark>$1</mark>", $item['title']);
                $highlighted_description = preg_replace("/(" . preg_quote($search_query, '/') . ")/i", "<mark>$1</mark>", $item['description']);

                $search_results[] = [
                    "title" => $highlighted_title,
                    "description" => $highlighted_description,
                    "link" => $item['link']
                ];
            }
        }

        // If no results found, handle accordingly
        if (empty($search_results)) {
            $search_results[] = [
                "title" => "No results found for \"" . $search_query . "\"",
                "description" => "Try refining your search query or check for typos.",
                "link" => "#"
            ];
        }

        // Implement pagination
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($current_page < 1) $current_page = 1;
        $total_results = count($search_results);
        $total_pages = ceil($total_results / $results_per_page);
        if ($current_page > $total_pages) $current_page = $total_pages;
        $start_index = ($current_page - 1) * $results_per_page;
        $paginated_results = array_slice($search_results, $start_index, $results_per_page);
    }
}

$searchData = [
    // Original programming tutorials
    [
        "title" => "Learn PHP: The Basics of Server-Side Scripting",
        "description" => "An introductory guide to PHP programming for beginners.",
        "link" => "https://example.com/learn-php"
    ],
    [
        "title" => "CSS Styling Techniques for Modern Web Design",
        "description" => "Enhance your web pages with advanced CSS styling methods.",
        "link" => "https://example.com/css-styling"
    ],
    [
        "title" => "JavaScript Essentials: From Fundamentals to Advanced Concepts",
        "description" => "Master JavaScript to create dynamic and interactive web applications.",
        "link" => "https://example.com/javascript-essentials"
    ],
    [
        "title" => "Building Responsive Websites with HTML5 and CSS3",
        "description" => "Create mobile-friendly and responsive websites using the latest web technologies.",
        "link" => "https://example.com/responsive-websites"
    ],
    [
        "title" => "Backend Development with PHP and MySQL",
        "description" => "Develop robust backend systems using PHP and MySQL databases.",
        "link" => "https://example.com/php-mysql-backend"
    ],

    // Adding trending topics data
    [
        "title" => "ChatGPT: Complete Guide 2024",
        "description" => "Everything you need to know about ChatGPT, the revolutionary AI chatbot.",
        "link" => "https://example.com/chatgpt",
        "category" => "Technology"
    ],
    [
        "title" => "World Cup 2024: Teams, Schedule, and Predictions",
        "description" => "Complete coverage of World Cup 2024 including match schedules and team analysis.",
        "link" => "https://example.com/world-cup-2024",
        "category" => "Sports"
    ],
    [
        "title" => "Taylor Swift New Album: Release Date and Track List",
        "description" => "Get all the details about Taylor Swift's latest album release.",
        "link" => "https://example.com/taylor-swift-album",
        "category" => "Entertainment"
    ],
    [
        "title" => "iPhone 15: Features, Specs, and Reviews",
        "description" => "Comprehensive review of Apple's iPhone 15 including new features and improvements.",
        "link" => "https://example.com/iphone-15",
        "category" => "Technology"
    ],
    [
        "title" => "Climate Change News: Latest Updates",
        "description" => "Recent developments and breaking news about climate change and environmental issues.",
        "link" => "https://example.com/climate-change",
        "category" => "News"
    ],
    
    // Adding category pages
    [
        "title" => "Technology News and Updates",
        "description" => "Latest technology trends, news, and innovations.",
        "link" => "https://example.com/technology",
        "category" => "Technology"
    ],
    [
        "title" => "Sports Coverage and Updates",
        "description" => "Complete sports coverage including latest news and events.",
        "link" => "https://example.com/sports",
        "category" => "Sports"
    ],
    [
        "title" => "Entertainment News",
        "description" => "Latest updates from the entertainment world.",
        "link" => "https://example.com/entertainment",
        "category" => "Entertainment"
    ],
    [
        "title" => "News Headlines",
        "description" => "Breaking news and latest updates from around the world.",
        "link" => "https://example.com/news",
        "category" => "News"
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Engine</title>
    <style>
        body {
            background-color: #202124;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            padding: 150px 0 20px;
        }

        .header img {
            width: 272px;
            height: auto;
            margin-bottom: 20px;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .search-bar {
            display: flex;
            margin-bottom: 30px;
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-bar input[type="text"] {
            width: 100%;
            padding: 12px 40px;
            background: #202124;
            border: 1px solid #5f6368;
            border-radius: 24px;
            font-size: 16px;
            color: #fff;
            outline: none;
        }

        .search-bar input[type="text"]:hover,
        .search-bar input[type="text"]:focus {
            background-color: #303134;
            border-color: #303134;
            box-shadow: 0 1px 6px 0 #171717;
        }

        .search-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 20px;
        }

        .search-buttons button {
            background-color: #303134;
            border: 1px solid #303134;
            border-radius: 4px;
            color: #e8eaed;
            font-size: 14px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .search-buttons button:hover {
            border: 1px solid #5f6368;
        }

        .results {
            margin-top: 40px;
        }

        .result-item {
            margin-bottom: 20px;
            padding: 10px;
        }

        .result-item h3 {
            color: #8ab4f8;
            font-size: 20px;
            margin: 0 0 4px 0;
        }

        .result-item p {
            color: #bdc1c6;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .result-item a {
            color: #8ab4f8;
            text-decoration: none;
        }

        .result-item a:hover {
            text-decoration: underline;
        }

        .pagination {
            margin-top: 30px;
            text-align: center;
        }

        .pagination a, .pagination strong {
            color: #8ab4f8;
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #303134;
            border-radius: 4px;
            margin: 0 4px;
        }

        .pagination strong {
            background-color: #303134;
        }

        mark {
            background-color: #f1b74d30;
            color: #f1b74d;
        }

        .trending-section {
            margin-top: 10px;
            padding: 10px 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .trending-title {
            color: #bdc1c6;
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trending-title svg {
            width: 16px;
            height: 16px;
            fill: #8ab4f8;
        }

        .trending-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
        }

        .trending-item {
            background: #303134;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .trending-item:hover {
            background: #3c4043;
        }

        .trending-query {
            color: #e8eaed;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .trending-category {
            color: #8ab4f8;
            font-size: 12px;
        }

        .suggestions-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #303134;
            border: 1px solid #5f6368;
            border-radius: 0 0 8px 8px;
            margin-top: 1px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }

        .suggestion-item {
            padding: 10px 16px;
            color: #e8eaed;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .suggestion-item:hover {
            background: #3c4043;
        }

        .suggestion-item svg {
            width: 16px;
            height: 16px;
            fill: #9aa0a6;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination button {
            background: #303134;
            border: 1px solid #5f6368;
            color: #e8eaed;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .pagination button.active {
            background: #8ab4f8;
            color: #202124;
            border-color: #8ab4f8;
        }

        .pagination button:hover:not(.active) {
            border-color: #8ab4f8;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_light_color_272x92dp.png" alt="Logo">
    </div>

    <div class="container">
        <form name="searchForm" action="search.php" method="GET" onsubmit="return validateForm()">
            <div class="search-bar">
                <div class="search-icon">
                    <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#9aa0a6" d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                </div>
                <input type="text" 
                       name="query" 
                       id="searchInput"
                       placeholder="Search anything..." 
                       value="<?php echo isset($search_query) ? htmlspecialchars($search_query) : ''; ?>"
                       autocomplete="off"
                       autofocus>
                <div class="suggestions-container" id="suggestionsContainer"></div>
            </div>
            <div class="search-buttons">
                <button type="submit">Google Search</button>
                <button type="button" onclick="feelingLucky()">I'm Feeling Lucky</button>
            </div>
        </form>

        <div class="trending-section">
            <div class="trending-title">
                <svg viewBox="0 0 24 24">
                    <path d="M17.09 4.56c-.7-1.03-1.6-1.9-2.7-2.6-.51-.33-1.2-.19-1.54.32-.33.51-.19 1.2.32 1.54.84.54 1.55 1.21 2.12 2.05.38.56 1.14.7 1.7.32.56-.38.7-1.14.32-1.7.02.07.02.07-.22-.93zM6.09 9.94c.38.56 1.14.7 1.7.32.56-.38.7-1.14.32-1.7-.7-1.03-1.08-2.24-1.08-3.56 0-.62-.5-1.12-1.12-1.12s-1.12.5-1.12 1.12c0 1.77.52 3.4 1.5 4.82l-.2-.88zm7.82-3.56c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                </svg>
                Trending searches
            </div>
            <div class="trending-items" id="trendingItems">
                <!-- Trending items will be loaded here -->
            </div>
        </div>

        <div class="results">
            <?php if (!empty($search_results)): ?>
                <?php foreach ($paginated_results as $result): ?>
                    <div class="result-item">
                        <h3><?php echo $result['title']; ?></h3>
                        <p><?php echo $result['description']; ?></p>
                        <?php if ($result['link'] !== "#"): ?>
                            <a href="result.php?id=<?php echo urlencode($result['link']); ?>">Read More</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <!-- Pagination Links -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($current_page > 1): ?>
                            <a href="?query=<?php echo urlencode($search_query); ?>&page=<?php echo $current_page - 1; ?>">Previous</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <?php if ($i == $current_page): ?>
                                <strong><?php echo $i; ?></strong>
                            <?php else: ?>
                                <a href="?query=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                            <a href="?query=<?php echo urlencode($search_query); ?>&page=<?php echo $current_page + 1; ?>">Next</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])): ?>
                <div class="no-results">No results found for "<?php echo htmlspecialchars($search_query); ?>".</div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function validateForm() {
            var query = document.forms["searchForm"]["query"].value.trim();
            if (query === "") {
                return false;
            }
            return true;
        }

        function feelingLucky() {
            // Add functionality for I'm Feeling Lucky button
            alert("I'm Feeling Lucky feature coming soon!");
        }

        // Add this function to load trending searches
        async function loadTrendingSearches() {
            try {
                const response = await fetch('api/trending-api.php');
                const data = await response.json();
                
                if (data.status === 'success') {
                    const trendingItems = document.getElementById('trendingItems');
                    trendingItems.innerHTML = data.trending.map(item => `
                        <div class="trending-item" onclick="searchTrending('${item.query}')">
                            <div class="trending-query">${item.query}</div>
                            <div class="trending-category">${item.category}</div>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Error loading trending searches:', error);
            }
        }

        // Function to search when clicking a trending item
        function searchTrending(query) {
            document.forms["searchForm"]["query"].value = query;
            performSearch();
        }

        // Load trending searches when page loads
        document.addEventListener('DOMContentLoaded', loadTrendingSearches);

        let currentPage = 1;
        const resultsPerPage = 5;
        let allResults = [];

        // Debounce function to limit API calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Fetch suggestions
        const fetchSuggestions = debounce(async (query) => {
            if (query.length < 2) {
                document.getElementById('suggestionsContainer').style.display = 'none';
                return;
            }

            try {
                const response = await fetch(`api/suggestions.php?q=${encodeURIComponent(query)}`);
                const suggestions = await response.json();
                
                const container = document.getElementById('suggestionsContainer');
                if (suggestions.length > 0) {
                    container.innerHTML = suggestions.map(suggestion => `
                        <div class="suggestion-item" onclick="selectSuggestion('${suggestion}')">
                            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </svg>
                            ${suggestion}
                        </div>
                    `).join('');
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            } catch (error) {
                console.error('Error fetching suggestions:', error);
            }
        }, 300);

        // Handle suggestion selection
        function selectSuggestion(suggestion) {
            document.getElementById('searchInput').value = suggestion;
            document.getElementById('suggestionsContainer').style.display = 'none';
            performSearch();
        }

        // Update pagination
        function updatePagination(totalResults) {
            const totalPages = Math.ceil(totalResults / resultsPerPage);
            const pagination = document.getElementById('pagination');
            
            let html = '';
            
            // Previous button
            html += `<button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>`;
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                html += `<button onclick="changePage(${i})" class="${currentPage === i ? 'active' : ''}">${i}</button>`;
            }
            
            // Next button
            html += `<button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
            
            pagination.innerHTML = html;
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            displayResults();
        }

        // Display results for current page
        function displayResults() {
            const startIndex = (currentPage - 1) * resultsPerPage;
            const endIndex = startIndex + resultsPerPage;
            const pageResults = allResults.slice(startIndex, endIndex);
            
            // Update results display
            const resultsContainer = document.querySelector('.results');
            resultsContainer.innerHTML = pageResults.map(result => `
                <div class="result-item">
                    <h3><a href="${result.link}">${result.title}</a></h3>
                    <p>${result.description}</p>
                    <a href="${result.link}" class="result-url">${result.link}</a>
                </div>
            `).join('');
            
            updatePagination(allResults.length);
        }

        // Add event listener for search input
        document.getElementById('searchInput').addEventListener('input', (e) => {
            fetchSuggestions(e.target.value);
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-bar')) {
                document.getElementById('suggestionsContainer').style.display = 'none';
            }
        });
    </script>
</body>
</html>
