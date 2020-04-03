<?php

namespace Jackal\Downloader\Ext\Vimeo\Downloader;

use Jackal\Downloader\Downloader\AbstractDownloader;

class VimeoDownloader extends AbstractDownloader
{
    const VIDEO_TYPE = 'vimeo';

    public function getURL(): string
    {
        $decode_to_arr = json_decode($this->getVideoInfo(), true);
        $title = $decode_to_arr['video']['title'];
        $link_array = $decode_to_arr['request']['files']['progressive'];
        $final_link_arr = [];

        //Create array containing the detail of video
        for($i = 0; $i < count($link_array); $i++) {
            $link_array[$i]['title'] = $title;
            $mime = explode('/', $link_array[$i]['mime']);
            $link_array[$i]['format'] = $mime[1];
        }

        $links = array_reduce($link_array, function ($vimeoVideos, $currentVimeoVideo){
                $quality = substr($currentVimeoVideo['quality'], 0, -1);
                $vimeoVideos[$quality] = $currentVimeoVideo['url'];

                return $vimeoVideos;
        });

        ksort($links);

        if($this->getFormat() and !isset($links[$this->getFormat()])){
            throw new \Exception(
                sprintf('Format %s is not available. [Available formats are: %s]',
                    $this->getFormat(), implode(', ', array_keys($links))
                )
            );
        }

        return $this->getFormat() ? $links[$this->getFormat()] : end($links);
    }

    protected function getFormat() : ?string {
        return $this->options['format'];
    }

    /////////////////////////////////////////////////
    /*
    * Get the video information
    * return string
    */

    private function getVideoInfo() {
        return file_get_contents($this->getRequestedUrl());
    }

    /*
     * Get video Id
     * @param string
     * return string
     */

    private function extractVideoId($video_url)
    {
        $start_position = stripos($video_url, '.com/');

        return ltrim(substr($video_url, $start_position), '.com/');
    }

    /*
     * Scrap the url from the page
     * return string
     */
    private function getRequestedUrl()
    {
        $data = file_get_contents('https://www.vimeo.com/' . $this->extractVideoId($this->getVideoId()));
        $data = stristr($data, 'config_url":"');
        $start = substr($data, strlen('config_url":"'));
        $stop = stripos($start, ',');
        $str = substr($start, 0, $stop);

        return rtrim(str_replace('\\', '', $str), '"');
    }
}