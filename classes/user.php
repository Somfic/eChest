<?php
class User
{
    private $_db = null;
    private $_data = null;
    private $_sessionName;
    private $_cookieName;
    private $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //process logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function register($username = null, $password = null)
    {
        $db = $this->_db;

        $salt = Hash::salt(32);

        $uid = json_decode(Cors::get("https://api.mojang.com/users/profiles/minecraft/{$username}"))->id;
        $username = end(json_decode(Cors::get("https://api.mojang.com/user/profiles/{$uid}/names")))->name;
        $values = array(
            'uid' => $uid,
            'password' => Hash::make($password, $salt),
            'salt' => $salt,
            'username' => $username,
            'nickname' => $username,
            'group' => 1
        );

        if (!$db->insert('users', $values)) {
            throw new Exception('Could not create account.');
        }
    }

    public function login($username = null, $password = null, $remember = false)
    {
        $user = $this->find($username, 'username');

        if (!$username && !$password && $this->exists()) {
            Session::set($this->_sessionName, $this->data()['id']);
        } else {
            if ($user) {
                if ($this->data()['password'] === Hash::make($password, $this->data()['salt'])) {
                    Session::set($this->_sessionName, $this->data()['id']);

                    if ($remember) {
                        $db = $this->_db;
                        $hash = Hash::unique();
                        $hashCheck =  $db->where('user_id', $this->data()['id'])->getOne('users_session');

                        if ($db->count == 0) {
                            $db->insert('users_session', [
                                'user_id' => $this->data()['id'],
                                'hash' => $hash,
                            ]);
                        } else {
                            $hash = $hashCheck['hash'];
                        }

                        Cookie::set($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function logout()
    {
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);

        $db = $this->_db;
        $db->where('user_id', $this->data()['id'])->delete('users_session');
    }

    public function update($fields = array(), $id = null)
    {
        $db = $this->_db;

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()['id'];
        }

        //todo: fix
        //array_push($fields, ["updated_at" => date('Y-m-d H:i:s')]);

        $db->where('id', $id)->update('users', $fields);
    }

    public function hasPermission($level)
    {
        $db = $this->_db;
        try {
            $db->where('id', $this->data()['group'])->where($level, '1')->getOne('groups');

            if ($db->count > 0) {
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function find($user = null, $field = null)
    {
        $db = $this->_db;

        if ($user) {
            if (!$field) {
                $field = (is_numeric($user)) ? 'id' : 'uid';
            }

            $db->where($field, $user);
            $data = $db->getOne('users');

            if (isset($data)) {
                $this->_data = $data;
                return true;
            }

            return false;
        }
    }

    public function data()
    {
        return $this->_data;
    }

    public function avatar()
    {
        return "https://minotar.net/helm/" . $this->data()['uid'];
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function exists()
    {
        return (!empty($this->data())) ? true : false;
    }
}
