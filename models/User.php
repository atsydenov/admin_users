<?php

class User
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $role;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $second_name;

    /**
     * @var string
     */
    public $sex;

    /**
     * @var string
     */
    public $date_of_birth;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * User per page.
     */
    const USER_PER_PAGE = 3;

    /**
     * Sort parameters.
     */
    const SORT_LOGIN_ASC = 'login';
    const SORT_LOGIN_DESC = '-login';
    const SORT_DATE_OF_BIRTH_ASC = 'date_of_birth';
    const SORT_DATE_OF_BIRTH_DESC = '-date_of_birth';
    const SORT_CREATED_AT_ASC = 'created_at';
    const SORT_CREATED_AT_DESC = '-created_at';
    const SORT_UPDATED_AT_ASC = 'updated_at';
    const SORT_UPDATED_AT_DESC = '-updated_at';

    /**
     * Roles.
     */
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * User constructor.
     * @param $login
     * @param $password
     * @param $first_name
     * @param $second_name
     * @param $sex
     * @param $date_of_birth
     */
    public function __construct($login = '', $password = '', $first_name = '', $second_name = '', $sex = '', $date_of_birth = '')
    {
        $this->login = $login;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->sex = $sex;
        $this->date_of_birth = $date_of_birth;
    }

    /**
     * @param $oldLogin
     * @return array|bool
     */
    public function validateUser($oldLogin = '')
    {
        $errors = false;

        if (!$this->validateLogin()) {
            $errors[] = 'Login must not be shorter than 5 letters.';
        }

        # Create user
        if (empty($oldLogin) && (int) $this->userExists() > 0) {
            $errors[] = 'Login is already in use.';
        }

        # Update user
        if (!empty($oldLogin) && $oldLogin != $this->login) {
            if ((int) $this->userExists() > 0) {
                $errors[] = 'Login is already in use.';
            }
        }

        if (!$this->validatePassword()) {
            $errors[] = 'Password must not be shorter than 5 letters.';
        }

        if (!$this->validateFirstName()) {
            $errors[] = 'First name must not be shorter than 5 letters.';
        }

        if (!$this->validateSecondName()) {
            $errors[] = 'Second name must not be shorter than 5 letters.';
        }

        if (!$this->validateDateOfBirth()) {
            $errors[] = 'Date of birth is incorrect.';
        }

        if ($errors == false) {
            $errors = true;
        }

        return $errors;
    }

    /**
     * @return bool
     */
    public function saveUser()
    {
        $currentDate = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `user` "
            . "(login, password, first_name, second_name, sex, date_of_birth, updated_at) "
            . "VALUES "
            . "(:login, :password, :first_name, :second_name, :sex, :date_of_birth, :currentDate);";

        if ($this->id > 0) {
            $sql = "UPDATE `user` SET "
                . "login = :login, "
                . "password = :password, "
                . "first_name = :first_name, "
                . "second_name = :second_name, "
                . "sex = :sex, "
                . "date_of_birth = :date_of_birth, "
                . "updated_at = :currentDate "
                . "WHERE id = :id;";
        }

        $db = new DB();
        $connectionDB = $db->getConnection();
        $result = $connectionDB->prepare($sql);
        $result->bindParam(":login", $this->login, PDO::PARAM_STR);
        $result->bindParam(":password", $this->password, PDO::PARAM_STR);
        $result->bindParam(":first_name", $this->first_name, PDO::PARAM_STR);
        $result->bindParam(":second_name", $this->second_name, PDO::PARAM_STR);
        $result->bindParam(":sex", $this->sex, PDO::PARAM_STR);
        $result->bindParam(":date_of_birth", $this->date_of_birth, PDO::PARAM_STR);
        $result->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
        if ($this->id > 0) {
            $result->bindParam(":id", $this->id, PDO::PARAM_INT);
        }

        $return = false;
        if ($result->execute()) {
            $return = true;
        }
        return $return;
    }

    /**
     * Get user by ID.
     * @param int $id
     * @return mixed
     */
    public static function getUser(int $id)
    {
        $sql = "SELECT * FROM `user` WHERE id = :id";

        $db = new DB();
        $connectionDB = $db->getConnection();
        $result = $connectionDB->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result = $result->fetch();

        $user = null;
        if ($result) {
            $user = new User(
                $result['login'],
                $result['password'],
                $result['first_name'],
                $result['second_name'],
                $result['sex'],
                $result['date_of_birth']
            );

            $user->id = $id;
            $user->role = $result['role'];
            $user->created_at = $result['created_at'];
            $user->updated_at = $result['updated_at'];
        }
        return $user;
    }

    /**
     * @return bool
     */
    public function deleteUser()
    {
        $sql = "DELETE FROM `user` WHERE id = :id";

        $db = new DB();
        $connectionDB = $db->getConnection();
        $result = $connectionDB->prepare($sql);
        $result->bindParam(":id", $this->id, PDO::PARAM_INT);
        $return = false;
        if ($result->execute()) {
            $return = true;
        }
        return $return;
    }

    /**
     * Validate length of login.
     * @return bool
     */
    public function validateLogin()
    {
        $result = false;
        if (strlen($this->login) >= 5) {
            $result = true;
        }
        return $result;
    }

    /**
     * @param bool $isLogin
     * @return bool
     */
    public function userExists($isLogin = false)
    {
        $sql = "SELECT `id` FROM `user` WHERE login = :login";

        if ($isLogin) {
            $sql = "SELECT `id` FROM `user` WHERE login = :login AND password = :password;";
        }

        $db = new DB();
        $connectionDB = $db->getConnection();
        $result = $connectionDB->prepare($sql);
        $result->bindParam(":login", $this->login, PDO::PARAM_STR);
        if ($isLogin) {
            $result->bindParam(":password", $this->password, PDO::PARAM_STR);
        }
        $result->execute();
        $result->setFetchMode(PDO::FETCH_OBJ);
        $user = $result->fetch();

        $return = (isset($user->id) && $user->id > 0) ? $user->id : 0;
        return $return;
    }

    /**
     * Validate length of password.
     * @return bool
     */
    public function validatePassword()
    {
        $result = false;
        if (strlen($this->password) >= 5) {
            $result = true;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function validateFirstName()
    {
        $result = false;
        if (strlen($this->first_name) >= 5) {
            $result = true;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function validateSecondName()
    {
        $result = false;
        if (strlen($this->second_name) >= 5) {
            $result = true;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function validateDateOfBirth()
    {
        $result = false;
        $now = date('Y-m-d');
        if ($now >= $this->date_of_birth && !empty($this->date_of_birth)) {
            $result = true;
        }
        return $result;
    }

    /**
     * Get list of users per page.
     * @param int $page
     * @param string $sort
     * @return array
     */
    public static function getUserList($sort, int $page)
    {
        $limit = self::USER_PER_PAGE;
        $offset = ($page - 1) * self::USER_PER_PAGE;

        $sql = self::getRequestSQL($sort);

        $db = new DB();
        $connectionDB = $db->getConnection();
        $result = $connectionDB->prepare($sql);
        $result->bindParam(":limit", $limit, PDO::PARAM_INT);
        $result->bindParam(":offset", $offset, PDO::PARAM_INT);
        $result->execute();

        $userList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $userList[$i]['id'] = $row['id'];
            $userList[$i]['login'] = $row['login'];
            $userList[$i]['first_name'] = $row['first_name'];
            $userList[$i]['second_name'] = $row['second_name'];
            $userList[$i]['sex'] = $row['sex'];
            $userList[$i]['date_of_birth'] = $row['date_of_birth'];
            $userList[$i]['created_at'] = $row['created_at'];
            $userList[$i]['updated_at'] = $row['updated_at'];
            $i++;
        }

        return $userList;
    }

    /**
     * Get SQL request with sort.
     * @param $sort
     * @return string
     */
    public static function getRequestSQL($sort)
    {
        switch ($sort) {
            case self::SORT_LOGIN_ASC:
                $sql = 'SELECT * FROM `user` ORDER BY `login` LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_DATE_OF_BIRTH_ASC:
                $sql = 'SELECT * FROM `user` ORDER BY `date_of_birth` LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_UPDATED_AT_ASC:
                $sql = 'SELECT * FROM `user` ORDER BY `updated_at` LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_CREATED_AT_ASC:
                $sql = 'SELECT * FROM `user` ORDER BY `created_at` LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_LOGIN_DESC:
                $sql = 'SELECT * FROM `user` ORDER BY `login` DESC LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_DATE_OF_BIRTH_DESC:
                $sql = 'SELECT * FROM `user` ORDER BY `date_of_birth` DESC LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_UPDATED_AT_DESC:
                $sql = 'SELECT * FROM `user` ORDER BY `updated_at` DESC LIMIT :limit OFFSET :offset';
                break;
            case self::SORT_CREATED_AT_DESC:
                $sql = 'SELECT * FROM `user` ORDER BY `created_at` DESC LIMIT :limit OFFSET :offset';
                break;
            default:
                $sql = 'SELECT * FROM `user` LIMIT :limit OFFSET :offset';
                break;
        }

        return $sql;
    }

    /**
     * Return array of sort parameters.
     * @param $sort
     * @return array
     */
    public static function getSortParameters($sort)
    {
        $sortLogin = 'login';
        if ($sort == 'login') {
            $sortLogin = '-login';
        }

        $sortDateOfBirth = 'date_of_birth';
        if ($sort == 'date_of_birth') {
            $sortDateOfBirth = '-date_of_birth';
        }

        $sortCreatedAt = 'created_at';
        if ($sort == 'created_at') {
            $sortCreatedAt = '-created_at';
        }

        $sortUpdatedAt = 'updated_at';
        if ($sort == 'updated_at') {
            $sortUpdatedAt = '-updated_at';
        }

        return [
            'sortLogin' => $sortLogin,
            'sortDateOfBirth' => $sortDateOfBirth,
            'sortCreatedAt' => $sortCreatedAt,
            'sortUpdatedAt' => $sortUpdatedAt
        ];
    }

    /**
     * Get amount of users.
     * @return int
     */
    public static function getAmountUser()
    {
        $sql = 'SELECT COUNT(*) FROM `user`';

        $db = new DB();
        $connectionDB = $db->getConnection();
        $result = $connectionDB->prepare($sql);
        $result->execute();

        $amountUser = intval($result->fetchColumn());
        return $amountUser;
    }

    /**
     * Load user attributes from array.
     * @param array $array
     */
    public function load(array $array)
    {
        $this->login = (isset($array['login'])) ? mb_substr($array['login'], 0, 255) : '';
        $this->password = (isset($array['password'])) ? mb_substr($array['password'], 0, 255) : '';
        $this->first_name = (isset($array['first_name'])) ? mb_substr($array['first_name'], 0, 255) : '';
        $this->second_name = (isset($array['second_name'])) ? mb_substr($array['second_name'], 0, 255) : '';
        $this->sex = (isset($array['sex'])) ? $array['sex'] : '';
        $this->date_of_birth = (isset($array['date_of_birth'])) ? $array['date_of_birth'] : '';
    }

    /**
     * Write UserID in session.
     * @param $userID
     */
    public static function rememberUser($userID)
    {
        $_SESSION['user'] = $userID;
    }

    /**
     * @return bool
     */
    public static function isAuth()
    {
        $result = false;
        if (isset($_SESSION['user']) && $_SESSION['user'] > 0) {
            $result = true;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function hasPermission()
    {
        $result = false;
        if ($this->role == self::ROLE_ADMIN) {
            $result = true;
        }
        return $result;
    }
}
