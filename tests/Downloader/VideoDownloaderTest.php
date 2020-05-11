<?php

namespace Jackal\Downloader\Ext\Vimeo\Tests\Downloader;

use Jackal\Downloader\Ext\Vimeo\Downloader\VimeoDownloader;
use PHPUnit\Framework\TestCase;

class VideoDownloaderTest extends TestCase
{
    public function getURLs(){
        return [
            ['https://vimeo.com/168915244'],
            ['<iframe src="https://player.vimeo.com/video/168915244" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'],
        ];
    }

    /**
     * @dataProvider getURLs
     */
    public function testGetPublicUrlRegex($string){

        preg_match(VimeoDownloader::getPublicUrlRegex(), $string, $matches);

        $this->assertEquals(168915244, $matches[1]);

    }
}