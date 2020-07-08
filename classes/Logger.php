
<?php
class Logger
{
    public static function log($content, $user = null, $level = 1, $user_type = 1)
    {
        $id = null;

        if ($user != null) {
            $id = $user->data()['id'];
        }

        $db = Database::getInstance();

        $db->insert('audits', [
            'user_id' => $id,
            'action_type' => 1,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'level' => $level,
            'message' => $content
        ]);
    }

    public static function admin($content, $user = null, $level = 1)
    {
        log($content, $user, $level, 2);
    }
}
