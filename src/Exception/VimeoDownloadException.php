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

    public static function formatNotFound(array $selectedFormats, array $available)
    {
        return new VimeoDownloadException(sprintf(
            'Format%s %s is not available. [Available formats are: %s]',
            count($selectedFormats) == 1 ? '' : 's',
            implode(', ', $selectedFormats),
            implode(', ', array_keys($available))
        ));
    }
}
