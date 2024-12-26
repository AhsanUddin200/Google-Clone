<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            background: #202124;
            color: #e8eaed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .results-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .search-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #3c4043;
        }

        .search-query {
            color: #8ab4f8;
            font-size: 20px;
            margin: 0;
        }

        .search-stats {
            color: #9aa0a6;
            font-size: 14px;
            margin-top: 5px;
        }

        .result-card {
            background: #303134;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        .result-card:hover {
            background: #3c4043;
            transform: translateY(-2px);
        }

        .result-title {
            color: #8ab4f8;
            font-size: 18px;
            margin: 0 0 8px 0;
            text-decoration: none;
            display: block;
        }

        .result-title:hover {
            text-decoration: underline;
        }

        .result-link {
            color: #969ba1;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
            text-decoration: none;
        }

        .result-description {
            color: #bdc1c6;
            font-size: 14px;
            margin: 8px 0;
        }

        .result-category {
            display: inline-block;
            padding: 4px 12px;
            background: #3c4043;
            color: #8ab4f8;
            border-radius: 12px;
            font-size: 12px;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #9aa0a6;
        }
    </style>
</head>
<body>
    <div class="results-container">
        <?php
        // Get search query from URL
        $search_query = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
        
        // Function to filter results based on search query
        function filterResults($query, $data) {
            return array_filter($data, function($item) use ($query) {
                return (
                    stripos($item['title'], $query) !== false ||
                    stripos($item['description'], $query) !== false ||
                    stripos($item['category'], $query) !== false
                );
            });
        }

        // Get filtered results
        $results = filterResults($search_query, $searchData);
        $total_results = count($results);
        ?>

        <!-- Search Header -->
        <div class="search-header">
            <h1 class="search-query"><?php echo $search_query; ?></h1>
            <div class="search-stats">
                <?php echo $total_results; ?> results found
            </div>
        </div>

        <!-- Results Section -->
        <?php if ($total_results > 0): ?>
            <?php foreach ($results as $result): ?>
                <div class="result-card">
                    <a href="<?php echo $result['link']; ?>" class="result-title">
                        <?php echo $result['title']; ?>
                    </a>
                    <a href="<?php echo $result['link']; ?>" class="result-link">
                        <?php echo $result['link']; ?>
                    </a>
                    <p class="result-description">
                        <?php echo $result['description']; ?>
                    </p>
                    <span class="result-category">
                        <?php echo $result['category']; ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">
                <h2>No results found</h2>
                <p>Try different keywords or check your spelling</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Highlight search terms in results
        function highlightSearchTerms() {
            const searchQuery = '<?php echo $search_query; ?>'.toLowerCase();
            const terms = searchQuery.split(' ').filter(term => term.length > 2);
            
            if (terms.length === 0) return;

            document.querySelectorAll('.result-description').forEach(element => {
                let text = element.textContent;
                terms.forEach(term => {
                    const regex = new RegExp(`(${term})`, 'gi');
                    text = text.replace(regex, '<mark>$1</mark>');
                });
                element.innerHTML = text;
            });
        }

        // Run when page loads
        document.addEventListener('DOMContentLoaded', highlightSearchTerms);
    </script>

    <style>
        /* Additional styles for highlighting */
        mark {
            background-color: rgba(138, 180, 248, 0.2);
            color: #8ab4f8;
            padding: 0 2px;
            border-radius: 2px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .results-container {
                padding: 10px;
            }

            .result-card {
                padding: 12px;
            }

            .search-query {
                font-size: 18px;
            }
        }
    </style>
</body>
</html> 