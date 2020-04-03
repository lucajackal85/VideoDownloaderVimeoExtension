<?php

namespace Jackal\Downloader\Ext\Vimeo\Downloader;

use Jackal\Downloader\Downloader\AbstractDownloader;
use Jackal\Downloader\Ext\Vimeo\Exception\VimeoDownloadException;

class VimeoDownloader extends AbstractDownloader
{
    const VIDEO_TYPE = 'vimeo';

    public function getURL(): string
    {
        $videos = $this->getVideoInfo();
        $selectedFormats = $this->getFormats();

        $links = array_reduce($videos, function ($vimeoVideos, $currentVimeoVideo) {
            $quality = substr($currentVimeoVideo['quality'], 0, -1);
            $vimeoVideos[$quality] = $currentVimeoVideo['url'];

            return $vimeoVideos;
        }, []);

        ksort($links, SORT_NUMERIC);

        if ($links == []) {
            throw VimeoDownloadException::videoURLsNotFound();
        }

        if($selectedFormats != []) {
            foreach ($selectedFormats as $selectedFormat) {
                if (array_key_exists($selectedFormat, $links)) {
                    return $links[$selectedFormat];
                }
            }

            throw VimeoDownloadException::formatNotFound($selectedFormats, $links);
        }

        return array_values($links)[0];
    }

    protected function getFormats() : array
    {
        if(!isset($this->options['format'])){
            return [];
        }

        if(!is_array($this->options['format'])){
            return [$this->options['format']];
        }

        return $this->options['format'];

    }

    private function getVideoInfo() : array
    {
        $requestUrl = $this->getRequestedUrl();
        $requestUrlContent = file_get_contents($requestUrl);
        $decode_to_arr = json_decode($requestUrlContent, true);

        $contentToReturn = @$decode_to_arr['request']['files']['progressive'];
        if (!$decode_to_arr or !is_array($contentToReturn)) {
            throw VimeoDownloadException::unableToParseContent($requestUrl, $requestUrlContent);
        }

        return $contentToReturn;
    }

    private function getRequestedUrl() : string
    {
        $originUrl = 'https://www.vimeo.com/' . $this->getVideoId();
        $data = file_get_contents($originUrl);

        $url = $this->executeRegex($data, '/"config_url"\:"(.*)"/U');
        $url = trim(str_replace('\\/', '/', $url));

        if (!$url or !filter_var($url, FILTER_VALIDATE_URL)) {
            throw VimeoDownloadException::unableToParseContent($originUrl, $url);
        }

        return $url;
    }

    protected function executeRegex($string, $regex, $group = 1) : ?string
    {
        preg_match($regex, $string, $matches);
        if (!array_key_exists($group, $matches)) {
            return null;
        }

        return $matches[$group];
    }
}
