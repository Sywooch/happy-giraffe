<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 20/01/14
 * Time: 18:31
 * To change this template use File | Settings | File Templates.
 */

class ReportHelper
{
    public static function getIconClass($report)
    {
        switch ($report->type) {
            case AntispamReport::TYPE_LIMIT:
                return self::getLimitIconClass($report);
        }
    }

    public static function getLimitIconClass($report)
    {
        switch ($report->data->entity) {
            case 'BlogContent':
            case 'CommunityContent':
                return 'blog';
            case 'AlbumPhoto':
                return 'photo';
            case 'Comment':
                return 'new';
            case 'MessagingMessage':
                return 'msg';
        }
    }

    public static function getAnalysisUrl($report)
    {

    }
}