<?php

use Jackal\Downloader\Ext\Vimeo\Downloader\VimeoDownloader;

require_once __DIR__ . '/vendor/autoload.php';

$vimeo = '402214386';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(VimeoDownloader::VIDEO_TYPE, VimeoDownloader::class);

$downloader = $vd->getDownloader(VimeoDownloader::VIDEO_TYPE, $vimeo, [
    'format' => 240,
]);

$downloader->download(__DIR__ . '/output.avi');