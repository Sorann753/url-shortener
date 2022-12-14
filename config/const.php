<?php
$server = $_SERVER['SERVER_SOFTWARE'];
if (strpos($server, 'nginx')) {
    define('BASE_URL', $_SERVER['SERVER_NAME'] . '/url-shortener');
} else {
    define('BASE_URL', 'http://localhost/url-shortener');
}
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/url-shortener');

define('LOG_FILE', ROOT_PATH . "/logs/log-" . date('Y-m-d') . ".log");
define('LOG_LVL_CRITICAL', 1);
define('LOG_LVL_ERROR', 2);
define('LOG_LVL_INFO', 3); // enum from php 8.1 would be better but i'm currently coding in php 7.4
define('LOG_LVL_DEBUG', 4);
define('LOG_LVL_VERBOSE', 5);
define('LOG_LEVEL', LOG_LVL_INFO);

define('MAX_FILE_SIZE', 12000000); // 12MB
define('UPLOAD_PATH', ROOT_PATH . '/uploads');

if (!function_exists('mime_content_type')) {

    /**
     * get the mime type of a file
     * @param string $fileName
     * @return string
     */
    function mime_content_type($fileName)
    {
        $mimeTypes = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.', $fileName)));
        if (array_key_exists($ext, $mimeTypes)) {
            return $mimeTypes[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimeType = finfo_file($finfo, $fileName);
            finfo_close($finfo);
            return $mimeType;
        } else {
            return 'application/octet-stream';
        }
    }
}
