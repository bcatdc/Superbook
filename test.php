<?php
function convertHtmlToNotionBlocks($htmlContent) {
    $dom = new DOMDocument();
    @$dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $blocks = [];
    foreach ($dom->childNodes as $node) {
        if ($node->nodeType == XML_ELEMENT_NODE || $node->nodeType == XML_TEXT_NODE) {
            $block = processNode($node);
            if (!empty($block)) {
                $blocks[] = $block;
            }
        }
    }

    return $blocks;
}

function processNode($node) {
    $block = [];
    switch ($node->nodeName) {
        case 'p':
            $block = [
                "object" => "block",
                "type" => "paragraph",
                "paragraph" => [
                    "rich_text" => [
                        [
                            "type" => "text",
                            "text" => [
                                "content" => $node->textContent
                            ]
                        ]
                    ]
                ]
            ];
            break;
        case 'h1':
        case 'h2':
        case 'h3':
            $level = (int) substr($node->nodeName, 1);
            $block = [
                "object" => "block",
                "type" => "heading_{$level}",
                "heading_{$level}" => [
                    "rich_text" => [
                        [
                            "type" => "text",
                            "text" => [
                                "content" => $node->textContent
                            ]
                        ]
                    ]
                ]
            ];
            break;
        case '#text':
            if (trim($node->textContent) !== '') {
                $block = [
                    "object" => "block",
                    "type" => "paragraph",
                    "paragraph" => [
                        "rich_text" => [
                            [
                                "type" => "text",
                                "text" => [
                                    "content" => trim($node->textContent)
                                ]
                            ]
                        ]
                    ]
                ];
            }
            break;
        // Add more cases as needed for other HTML tags
    }

    return $block;
}

// Testing the function with sample HTML content
$htmlContent = '<p>Hello World!</p><h2>Heading 2</h2><p>Some initial <strong>bold</strong> text</p>';
$blocks = convertHtmlToNotionBlocks($htmlContent);

print_r($blocks); // Debug output
?>
