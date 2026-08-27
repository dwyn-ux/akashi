<?php
// Fallback if DocumentRoot not set to /public — forwards to public/index.php
// Proper fix: set DocumentRoot to /public in cPanel → Domains → Document Root
require __DIR__ . '/public/index.php';
