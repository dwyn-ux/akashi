<?php
// Fallback when DocumentRoot is not set to /public
// cPanel fix: Domains -> Document Root -> /home/proftweb/akashi.smpmuashidiq.sch.id/public
$public = __DIR__ . '/public';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Serve existing public files directly (css/js/images) if .htaccess is ignored
if ($uri !== '/' && $uri !== '') {
    $file = $public . $uri;
    if (is_file($file)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimes = ['css'=>'text/css','js'=>'application/javascript','mjs'=>'application/javascript','json'=>'application/json','png'=>'image/png','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','gif'=>'image/gif','svg'=>'image/svg+xml','woff'=>'font/woff','woff2'=>'font/woff2','ico'=>'image/x-icon','map'=>'application/json'];
        if (isset($mimes[$ext])) header('Content-Type: '.$mimes[$ext]);
        readfile($file);
        exit;
    }
}
require $public . '/index.php';
