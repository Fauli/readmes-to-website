<?php

$readmes = [
    "dj-table" => [
        "url" => "https://raw.githubusercontent.com/Fauli/dj-table/refs/heads/main/README.md",
        "date" => "2024-02-01",
        "title" => "DJ Table",
        "description" => "A project for creating a digital DJ table."
    ],
    "led-lattice" => [
        "url" => "https://raw.githubusercontent.com/Fauli/led-lattice/refs/heads/main/README.md",
        "date" => "2024-01-15",
        "title" => "LED Lattice",
        "description" => "A dynamic LED lattice lighting project."
    ],
    "self-hosting" => [
        "url" => "https://raw.githubusercontent.com/Fauli/self-hosting/refs/heads/main/README.md",
        "date" => "2024-02-10",
        "title" => "Self Hosting",
        "description" => "A guide and setup for self-hosting various services."
    ],
    "embroidery" => [
        "url" => "https://raw.githubusercontent.com/Fauli/embroidery/refs/heads/main/README.md",
        "date" => "2024-02-08",
        "title" => "Embroidery",
        "description" => "Projects and techniques for machine embroidery."
    ],
    "otteri-synth" => [
        "url" => "https://raw.githubusercontent.com/Fauli/otteri-synth/refs/heads/main/README.md",
        "date" => "2024-02-06",
        "title" => "Otteri Synth",
        "description" => "A synthesizer project inspired by otters."
    ],
    "nalewkas" => [
        "url" => "https://raw.githubusercontent.com/Fauli/nalewkas/refs/heads/main/README.md",
        "date" => "2024-02-05",
        "title" => "Nalewkas",
        "description" => "A collection of homemade liqueur recipes."
    ],
    "sloth-operator" => [
        "url" => "https://raw.githubusercontent.com/Fauli/sloth-operator/refs/heads/main/README.md",
        "date" => "2024-02-04",
        "title" => "Sloth Operator",
        "description" => "A Kubernetes operator with a relaxed approach."
    ],
    "schnuppern-plattform-entwickler" => [
        "url" => "https://raw.githubusercontent.com/Fauli/schnuppern-plattform-entwickler/refs/heads/main/README.md",
        "date" => "2024-02-03",
        "title" => "Schnuppern Plattform Entwickler",
        "description" => "A platform for aspiring developers to explore coding."
    ],
    "giffer" => [
        "url" => "https://raw.githubusercontent.com/Fauli/giffer/refs/heads/main/README.md",
        "date" => "2024-02-02",
        "title" => "Giffer",
        "description" => "A simple tool for creating GIFs from videos."
    ]
];

// Sort projects by date (newest first)
uksort($readmes, function ($a, $b) use ($readmes) {
    return strtotime($readmes[$b]['date']) - strtotime($readmes[$a]['date']);
});

function fetchMarkdown($url) {
    return file_get_contents($url);
}

function convertMarkdownToHtml($markdown, $repoName) {
    require_once 'Parsedown.php';
    $parsedown = new Parsedown();

    // Convert Markdown to HTML
    $html = $parsedown->text($markdown);

    // Fix image URLs (convert relative paths to absolute URLs)
    $githubRawBase = "https://raw.githubusercontent.com/Fauli/$repoName/refs/heads/main/";
    $html = preg_replace('/<img src="(?!https?:\/\/)([^"]+)"/i', '<img src="' . $githubRawBase . '$1" style="max-width: 100%; height: auto; display: block; margin: auto;"', $html);

    // Ensure anchor links remain on the same page without breaking
    $html = preg_replace('/<a href="#([^"]+)"/i', '<a href="?page=' . urlencode($repoName) . '#$1"', $html);
    
    // Add id attributes to headings to enable anchors (normalize ids to be lowercase and replace spaces with dashes)
    $html = preg_replace_callback('/<(h[1-6])>(.*?)<\/\1>/i', function ($matches) {
        $id = strtolower(trim($matches[2]));
        $id = preg_replace('/[^a-z0-9]+/', '-', $id); // Replace non-alphanumeric characters with dashes
        return "<$matches[1] id=\"$id\">$matches[2]</$matches[1]>";
    }, $html);

    // Format tables for better readability
    $html = preg_replace('/<table>/', '<table style="width:100%; border-collapse: collapse; background-color: #1e1e2e; color: #cdd6f4; border: 1px solid #45475a;">', $html);
    $html = preg_replace('/<th>/', '<th style="border: 1px solid #45475a; padding: 8px; background-color: #313244; color: #cdd6f4;">', $html);
    $html = preg_replace('/<td>/', '<td style="border: 1px solid #45475a; padding: 8px;">', $html);
	    // Ensure code blocks wrap properly
    $html = preg_replace('/<pre>/', '<pre style="white-space: pre-wrap; word-wrap: break-word; background-color: #282c34; padding: 10px; border-radius: 5px;">', $html);
    $html = preg_replace('/<code>/', '<code style="font-family: monospace;">', $html);


    return $html;
}

$page = $_GET['page'] ?? 'home';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects</title>
    <style>
        body { font-family: 'JetBrains Mono', monospace; background-color: #1e1e2e; color: #cdd6f4; max-width: 1000px; margin: auto; padding: 20px; }
        a { text-decoration: none; color: #89b4fa; font-weight: bold; border-bottom: 2px solid #89b4fa; }
        a:hover { text-decoration: underline; color: #f5e0dc; border-bottom: 2px solid #f5e0dc; }
        img { max-width: 100%; height: auto; display: block; margin: auto; }
        .container { background-color: #181825; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px #45475a; }
        h1, h2 { color: #f5e0dc; }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #45475a; }
        li:last-child { border-bottom: none; }
        .project-title { font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Personal Projects</h1>
        
        <?php if ($page === 'home'): ?>
            <p>Welcome to my personal portfolio! Here you'll find various projects I've worked on.</p>
            <h2>Projects</h2>
            <ul>
                <?php foreach ($readmes as $name => $data): ?>
                    <li>
                        <span class="project-title"> <?= htmlspecialchars($data['title']) ?> </span> (<?= htmlspecialchars($data['date']) ?>)<br>
                        <p><?= htmlspecialchars($data['description']) ?></p>
                        <a href="?page=<?= urlencode($name) ?>">[View Project]</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (isset($readmes[$page])): ?>
            <p><a href="?page=home">&larr; Back to home</a></p>
            <?php 
                $markdown = fetchMarkdown($readmes[$page]['url']); 
                $html = convertMarkdownToHtml($markdown, $page);
                echo $html;
            ?>
            <p><a href="?page=home">&larr; Back to home</a></p>
        <?php else: ?>
            <p>Page not found.</p>
            <p><a href="?page=home">&larr; Back to home</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
