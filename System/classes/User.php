<?php
class User{

    /**
     *
     * Getting User by ID
     * @param $id int User ID
     * @return array|false|null Associative array with User fields
     */
    public function getUserById($id){
        global $mysqli;
        $user_result = $mysqli->query("SELECT * FROM user WHERE user_id = '$id'");
        $user = $user_result->fetch_assoc();
        return $user;
    }

    /**
     *
     * Getting User by username
     * @param $login string User login (username)
     * @return array|false|null Associative array with User fields
     */
    public function getUserByUserName($login){
        global $mysqli;
        $user_result = $mysqli->query("SELECT * FROM user WHERE login = '$login'");
        $user = $user_result->fetch_assoc();
        return $user;
    }

    /**
     *
     * Auth user in application
     *
     * @param $login string User login (username)
     * @param $password string User real password
     * @return void Print result on screen or redirect to main page if user exists
     */
    public function authUser($login, $password){
        global $mysqli;

        $hashed_password = md5($password);
        $result = $mysqli->query("SELECT * FROM user WHERE login = '".$login."' AND password = '".$hashed_password."'") or die($mysqli->error);
        $user = $result->fetch_assoc();

        if(!empty($user)){
            $_SESSION['login'] = $user['login'];
            $_SESSION['uid'] = $user['user_id'];
            echo "<script>location.replace('/index.php?page=main')</script>";
        }else{
            echo "<div class='alert alert-danger alert-dismissible fade show '>Username or Password not correct
 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  </button></div>";
        }
    }

    /**
     *
     * Register user
     * @param $login string User login (username)
     * @param $password string User real password
     * @param $first_name string User First Name
     * @param $last_name string User Last Name
     * @param $status string User status
     * @return string|void Status or MySQL error
     */
    public function registerUser($login, $password, $first_name, $last_name, $status){

        global $mysqli;

        $hashed_password = md5($password);
        $check_q = $mysqli->query("SELECT * FROM user WHERE login = '".$login."'");
        $user_count = $check_q->num_rows;

        if($user_count > 0){
            echo "<div class='alert alert-danger alert-dismissible fade show '> User exists!
 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  </button></div>";
        }else {
            $mysqli->query("
            INSERT INTO
                user (
                       login,
                       password, 
                       first_name,
                       last_name,
                       status
                       ) 
                VALUES 
                       (
                        '" . $login . "',
                        '" . $hashed_password . "',
                        '" . $first_name . "', 
                        '" . $last_name . "', 
                        '".$status."'
                        )  "
            )
            or
                die($mysqli->error);

            echo "<div class='alert alert-success alert-dismissible fade show '> User was registered
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  </button></div>";
        }
    }
    public function authAdmin($username, $password)
    {
        global $mysqli;

        $hashed_password = md5($password);
        $result = $mysqli->query("SELECT * FROM user WHERE login = '" . $username . "' AND password = '" . $hashed_password . "' AND status = 'admin'") or die($mysqli->error);
        $user = $result->fetch_assoc();

        if (!empty($user)) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['uid'] = $user['id'];
            echo "<script>location.replace('/admin_panel/?page=admin_main')</script>";
        } else {
            echo "Username or Password not correct";
        }
    }

}