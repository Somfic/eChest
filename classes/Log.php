<?php
class Log
{
    public static function debug($content = null)
    {
        $content = "[DEBUG] " . $content;

        file_put_contents('./log_' . date("j.n.Y") . '.log', $content . "\n", FILE_APPEND);
    }
}
