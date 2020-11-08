<?php

class Users extends Controller {
    public function __construct() {
        $this->userModel = $this->model('User');
    }

    // Form de registro e cadastro
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cadastro de usuário

            // Sanitize
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Data
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];

            // Email validation
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email.';
            } else if ($this->userModel->emailExists($_POST['email'])) {
                $data['email_error'] = 'This email is already taken.';
            }

            // Name validation
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter name.';
            }

            // Password validation
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password.';
            } else if (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be at least 6 charcters long.';
            }

            // Confirm Password validation
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please enter confirmation password.';
            } else if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_error'] = 'Passwords don\' match.';
            }

            // Post validation. Garantir que não foram encontrados problemas.
            if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                // Password hash
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data['name'], $data['email'], $data['password'])) {
                    flash('register_success', 'You are now registered.');

                    // Redirect to login
                    redirectToLogin();
                } else {
                    die('Error');
                }
            } else {
                $this->view('users/register', $data);
            }

        } else {
            // Carrega form view
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];

            $this->view('users/register', $data);
        }
    }

    // Form de login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cadastro
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Data
            $data = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'email_error' => '',
                'password_error' => '',
            ];

            // Email validation
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email.';
            }

            // Password validation
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password.';
            }

            // Check access
            if (!$this->userModel->emailExists($data['email'])) {
                $data['email_error'] = 'No user found.';
            }

            // var_dump($data['email_error'], $data['password_error'], !empty($data['email_error']), !empty($data['password_error']));die;
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // User validated
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = "Password incorrect.";
                    $this->view('users/login', $data);
                }
            }  else {
                // Load view w/ errors
                $this->view('users/login', $data);
            }

        } else {
            // Carrega form view
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];

            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) {
        if (is_object($user) &&
            property_exists($user, 'id') &&
            property_exists($user, 'name') &&
            property_exists($user, 'email')
        ) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            redirect('/pages/index');
        }

        return false;
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('/users/login');
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}