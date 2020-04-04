# VideoDownloaderVimeoExtension
[![Latest Stable Version](https://poser.pugx.org/jackal/video-downloader-ext-vimeo/v/stable)](https://packagist.org/packages/jackal/video-downloader-ext-vimeo)
[![Total Downloads](https://poser.pugx.org/jackal/video-downloader-ext-vimeo/downloads)](https://packagist.org/packages/jackal/video-downloader-ext-vimeo)
[![Latest Unstable Version](https://poser.pugx.org/jackal/video-downloader-ext-vimeo/v/unstable)](https://packagist.org/packages/jackal/video-downloader-ext-vimeo)
[![License](https://poser.pugx.org/jackal/video-downloader-ext-vimeo/license)](https://packagist.org/packages/jackal/video-downloader-ext-vimeo)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloaderVimeoExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloaderVimeoExtension/?branch=master)

**Vimeo extension for [jackal/video-downloader](https://github.com/lucajackal85/VideoDownloader)**

## Installation
```
composer require jackal/video-downloader-ext-vimeo
```

## Usage
```
use Jackal\Downloader\Ext\Vimeo\Downloader\VimeoDownloader;

require_once __DIR__ . '/vendor/autoload.php';

$vimeo = '71281510';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(VimeoDownloader::VIDEO_TYPE, VimeoDownloader::class);

$downloader = $vd->getDownloader(VimeoDownloader::VIDEO_TYPE, $vimeo, [
    'format' => [240,360],
]);

$downloader->download(__DIR__ . '/output.avi');
```
