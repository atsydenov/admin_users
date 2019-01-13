<?php

/**
 * Class UserController
 */
class UserController
{
    /**
     * @param string $sort
     * @param int $page
     * @return bool
     */
    public function actionIndex($sort = '', int $page = 1)
    {
        if (!User::isAuth()) {
            header('location: /');
        }

        $userList = User::getUserList($sort, $page);

        $createdUser = false;
        if (isset($_SESSION['createdUser']) && $_SESSION['createdUser'] == 'yes') {
            unset($_SESSION['createdUser']);
            $createdUser = true;
        }

        # Parameter use in view.
        $page = intval($page);
        $offset = ($page - 1) * User::USER_PER_PAGE;

        $total = User::getAmountUser();
        $pagination = new Pagination($total, $page, User::USER_PER_PAGE, 'page=', $sort);

        # Parameter use in view.
        $sortParams = User::getSortParameters($sort);

        require_once ROOT . '/views/index.php';

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function actionView(int $id)
    {
        if (!User::isAuth()) {
            header('location: /');
        }

        $user = User::getUser($id);
        if (!is_null($user)) {
            $backPath = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/user';
            require_once ROOT . '/views/view.php';
        } else {
            header('location: /404');
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function actionDelete(int $id)
    {
        if (!User::isAuth()) {
            header('location: /');
        }

        $user = User::getUser($id);
        if (!is_null($user)) {
            $result = $user->deleteUser();
            header('location: /user');
        } else {
            header('location: /404');
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function actionUpdate(int $id)
    {
        if (!User::isAuth()) {
            header('location: /');
        }

        $result = false;
        $user = User::getUser($id);

        if (is_null($user)) {
            header('location: /404');
        }

        $oldLogin = $user->login;
        $backPath = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/user';
        if (isset($_POST['submit'])) {
            $backPath = isset($_POST['backPath']) ? $_POST['backPath'] : '/user';
            $user->load($_POST);
            $errors = $user->validateUser($oldLogin);
            if ($errors === true) {
                if ($user->saveUser()) {
                    $result = true;
                } else {
                    $errors = [];
                    $errors[] = 'Unexpected error. User not saved.';
                }
            }
        }

        require_once ROOT . '/views/update.php';

        return true;
    }

    /**
     * @return bool
     */
    public function actionCreate()
    {
        if (!User::isAuth()) {
            header('location: /');
        }

        $user = new User();
        if (isset($_POST['submit'])) {
            $user->load($_POST);
            $errors = $user->validateUser();
            if ($errors === true) {
                if ($user->saveUser()) {
                    $_SESSION['createdUser'] = 'yes';
                    header('location: /user');
                } else {
                    $errors = [];
                    $errors[] = 'Unexpected error. User not saved.';
                }
            }
        }

        $backPath = '/user';
        require_once ROOT . '/views/create.php';

        return true;
    }

    /**
     * @return bool
     */
    public function actionLogin()
    {
        if (User::isAuth()) {
            header('location: /user');
        }

        $user = new User();
        if (isset($_POST['submit'])) {
            $user->load($_POST);
            $errors = false;

            $userID = $user->userExists(true);

            if ($userID > 0) {
                $user = User::getUser($userID);
                if ($user->hasPermission()) {
                    User::rememberUser($userID);
                    header("location: /user");
                } else {
                    header("location: /403");
                }
            } else {
                $errors[] = 'Login or password is incorrect!';
            }
        }

        require_once ROOT . '/views/login.php';
        return true;
    }

    /**
     * @return bool
     */
    public function action404()
    {
        header('HTTP/1.0 404 Not Found');
        require_once ROOT . '/views/page404.php';
        return true;
    }

    /**
     * @return bool
     */
    public function action403()
    {
        header('HTTP/1.0 403 Forbidden');
        require_once ROOT . '/views/page403.php';
        return true;
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        if (User::isAuth()) {
            unset($_SESSION['user']);
        }
        header('location: /user/login');
        return true;
    }
}
