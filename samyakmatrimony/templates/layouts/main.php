<?php
/**
 * Main Layout Template
 * Combines header and footer with content
 */

include __DIR__ . '/header.php';
echo $content ?? '';
include __DIR__ . '/footer.php';
