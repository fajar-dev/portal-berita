<?php

// Directories to create
$basePath = __DIR__ . '/storage/app/public';
$directories = [
    $basePath . '/avatars',
    $basePath . '/opinions',
    $basePath . '/infographics',
    $basePath . '/videos',
    $basePath . '/articles',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    }
}

// Download mapping (url => local path)
$downloads = [
    // Avatars
    'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150' => '/avatars/andika_wijaya.jpg',
    'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=150' => '/avatars/siti_rahma.jpg',
    'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=150' => '/avatars/budi_santoso.jpg',
    'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=150' => '/avatars/dwi_handoyo.jpg',
    'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=150' => '/avatars/laras_ayu.jpg',

    // Opinions
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150' => '/opinions/hermanto.jpg',
    'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150' => '/opinions/elizabeth.jpg',

    // Infographics
    'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=600' => '/infographics/ebt.jpg',
    'https://images.unsplash.com/photo-1544256718-3bcf237f3974?q=80&w=600' => '/infographics/telecom.jpg',
    'https://images.unsplash.com/photo-1515162305285-0293e4767cc2?q=80&w=600' => '/infographics/train.jpg',

    // Videos
    'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?q=80&w=600' => '/videos/plts.jpg',
    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=600' => '/videos/robot.jpg',
    'https://images.unsplash.com/photo-1545205597-3d9d02c29597?q=80&w=600' => '/videos/yoga.jpg',

    // Articles Main
    'https://images.unsplash.com/photo-1509391366360-2e959784a276?q=80&w=800' => '/articles/article_1.jpg',
    'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=800' => '/articles/article_2.jpg',
    'https://images.unsplash.com/photo-1507146426996-ef05306b995a?q=80&w=800' => '/articles/article_3.jpg',
    'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=800' => '/articles/article_4.jpg',
    'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=800' => '/articles/article_5.jpg',
    'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800' => '/articles/article_6.jpg',
    'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800' => '/articles/article_7.jpg',
    'https://images.unsplash.com/photo-1540959733332-eab4deceeaf7?q=80&w=800' => '/articles/article_8.jpg',
    'https://images.unsplash.com/photo-1521537634199-67398c740cc9?q=80&w=800' => '/articles/article_9.jpg',

    // Articles Content Figures (large width)
    'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?q=80&w=1200' => '/articles/article_1_figure.jpg',
    'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=1200' => '/articles/article_2_figure.jpg',
    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1200' => '/articles/article_3_figure.jpg',
    'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1200' => '/articles/article_4_figure.jpg',
    'https://images.unsplash.com/photo-1545205597-3d9d02c29597?q=80&w=1200' => '/articles/article_5_figure.jpg',
    'https://images.unsplash.com/photo-1618042164219-62c820f10723?q=80&w=1200' => '/articles/article_6_figure.jpg',
    'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1200' => '/articles/article_7_figure.jpg',
    'https://images.unsplash.com/photo-1474487548417-781cb71495f3?q=80&w=1200' => '/articles/article_8_figure.jpg',
];

echo "Starting download of " . count($downloads) . " images from Unsplash to public storage...\n";

$options = [
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n",
        'timeout' => 15,
    ]
];
$context = stream_context_create($options);

$successCount = 0;
foreach ($downloads as $url => $relPath) {
    $targetPath = $basePath . $relPath;
    echo "Downloading: $url -> $relPath... ";
    
    // Check if it already exists to avoid redundant network requests
    if (file_exists($targetPath) && filesize($targetPath) > 1000) {
        echo "Already exists! Skipping.\n";
        $successCount++;
        continue;
    }
    
    $data = @file_get_contents($url, false, $context);
    if ($data === false) {
        echo "FAILED!\n";
    } else {
        file_put_contents($targetPath, $data);
        echo "SUCCESS!\n";
        $successCount++;
    }
    usleep(100000); // 100ms pause to respect API
}

echo "Completed downloading. Successful: $successCount / " . count($downloads) . "\n";
