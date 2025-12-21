<?php
class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['title'] = 'Login';
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->authenticate_user($username, $password);
            
            if ($user) {
                // Set session data
                $session_data = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'full_name' => $user['full_name'],
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);
                
                // Redirect based on role
                redirect('dashboard');
            } else {
                $data['error'] = 'Invalid username or password';
                $this->load->view('auth/login', $data);
            }
        }
    }
    
    public function register() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['title'] = 'Register';
        
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/register', $data);
        } else {
            $user = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'full_name' => $this->input->post('full_name'),
                'role' => 'user', // Default role
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            $this->json_model->insert('users', $user);
            
            $data['success'] = 'Registration successful! Please login.';
            $this->load->view('auth/login', $data);
        }
    }
    
    public function logout() {
        $this->session->unset_userdata(['user_id', 'username', 'email', 'role', 'full_name', 'logged_in']);
        $this->session->sess_destroy();
        redirect('auth/login');
    }
    
    private function authenticate_user($username, $password) {
        $users = $this->json_model->get_all('users');
        
        foreach ($users as $user) {
            if ($user['username'] === $username && $user['status'] === 'active') {
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            }
        }
        return false;
    }
    
    // Callback to check if username already exists
    public function username_check($username) {
        $users = $this->json_model->get_all('users');
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $this->form_validation->set_message('username_check', 'Username already exists');
                return FALSE;
            }
        }
        return TRUE;
    }
    
    // Callback to check if email already exists
    public function email_check($email) {
        $users = $this->json_model->get_all('users');
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $this->form_validation->set_message('email_check', 'Email already registered');
                return FALSE;
            }
        }
        return TRUE;
    }
}