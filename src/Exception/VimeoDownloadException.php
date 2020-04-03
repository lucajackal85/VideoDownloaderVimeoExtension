<?php


namespace Jackal\Downloader\Ext\Vimeo\Exception;

use Jackal\Downloader\Exception\DownloadException;

class VimeoDownloadException extends DownloadException
{
    public static function unableToParseContent($contentUrl, $result) : VimeoDownloadException
    {
        return new VimeoDownloadException(sprintf('Unable to parse url "%s" [resulted in "%s"]', $contentUrl, $result));
    }

    public static function videoURLsNotFound() : VimeoDownloadException
    {
        return new VimeoDownloadException('No video URLs found');
    }
}
