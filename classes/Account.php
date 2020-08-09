<?php
class Account
{
    private $_db = null;
    private $_data = null;

    public function __construct($name = null)
    {
        $this->_db = Database::getInstance();

        if ($name) {
            $this->find($name);
        }
    }


    public function create($name = null, $userId = null)
    {
        $db = $this->_db;

        $uid = 'EC ' . random_int(10, 99) . ' ' . random_int(1000, 9999) . ' ' . random_int(1000, 9999) . ' ' .  random_int(10, 99);

        $values = array(
            'uid' => $uid,
            'name' => $name,
            'balance' => 0
        );

        $db->startTransaction();

        if ($db->insert('accounts', $values)) {
            $values = array(
                'user_id' => $userId,
                'account_id' => $db->getInsertId()
            );

            if ($db->insert('accounts_owners', $values)) {
                $db->commit();
                return;
            }
        }

        $db->rollback();
        throw new Exception($db->getLastError());
    }

    public function find($uid = null)
    {
        $db = $this->_db;

        if ($uid) {
            $db->where('uid', $uid);
            $data = $db->getOne('accounts');

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
}
