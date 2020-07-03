    <?php
    class Validation
    {
        private $_passed = false;
        private $_errors = array();
        private $_db = null;

        public function __construct()
        {
            $this->_db = Database::getInstance();
        }

        public function check($source, $items = array())
        {
            foreach ($items as $item => $rules) {
                $value = $source[$item];
                $item = escape($item);

                foreach ($rules as $rule => $rule_value) {
                    if ($rule === 'required' && empty($value)) {
                        $this->addError("{$item} is required");
                    } else if (!empty($value)) {
                        switch ($rule) {
                            case 'min':
                                if (strlen(trim($value)) < $rule_value) {
                                    $this->addError("{$item} must be longer than {$rule_value} characters");
                                }
                                break;

                            case 'max':
                                if (strlen(trim($value)) > $rule_value) {
                                    $this->addError("{$item} must be shorter than {$rule_value} characters");
                                }
                                break;

                            case 'matches':
                                if ($value != $source[$rule_value]) {
                                    $this->addError("{$rule_value} must match {$item}");
                                }
                                break;

                            case 'unique':
                                $db = $this->_db;
                                $db->where($item, $value);
                                $check = $db->get($rule_value);

                                if (count($check)) {
                                    $this->addError("{$item} already exists.");
                                }
                                break;

                            case 'validminecraft':
                                if (!isset(json_decode(Cors::get("https://api.mojang.com/users/profiles/minecraft/{$value}"))->id)) {
                                    $this->addError("{$value} is not a valid minecraft username.");
                                }
                                break;
                        }
                    }
                }
            }

            if (empty($this->errors())) {
                $this->_passed = true;
            }

            return $this;
        }

        public function passed()
        {
            return $this->_passed;
        }

        public function errors()
        {
            return $this->_errors;
        }

        private function addError($error)
        {
            $this->_errors[] = $error;
        }
    }
