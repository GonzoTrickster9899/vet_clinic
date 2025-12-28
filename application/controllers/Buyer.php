<?php
class Buyer extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    public function register() {
        if ($this->session->userdata('logged_in')) {
            redirect('marketplace');
        }
        
        $data['title'] = 'Buyer Registration';
        
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('buyer/register', $data);
        } else {
            $user = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'role' => 'buyer',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            $this->json_model->insert('users', $user);
            
            $data['success'] = 'Registration successful! Please login.';
            $this->load->view('buyer/login', $data);
        }
    }
    
    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('marketplace');
        }
        
        $data['title'] = 'Buyer Login';
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('buyer/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->authenticate_buyer($username, $password);
            
            if ($user) {
                $session_data = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'full_name' => $user['full_name'],
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);
                
                redirect('marketplace');
            } else {
                $data['error'] = 'Invalid username or password';
                $this->load->view('buyer/login', $data);
            }
        }
    }
    
    public function logout() {
        $this->session->unset_userdata(['user_id', 'username', 'email', 'role', 'full_name', 'logged_in']);
        $this->session->sess_destroy();
        redirect('marketplace');
    }
    
    public function account() {
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') !== 'buyer') {
            redirect('buyer/login');
        }
        
        $data['title'] = 'My Account';
        $data['user'] = $this->json_model->get_by_id('users', $this->session->userdata('user_id'));
        $data['is_buyer'] = true;
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('buyer/account', $data);
        $this->load->view('marketplace/footer');
    }
    
    public function orders() {
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') !== 'buyer') {
            redirect('buyer/login');
        }
        
        $data['title'] = 'My Orders';
        $all_orders = $this->json_model->get_all('orders');
        
        // Filter orders for current buyer
        $data['orders'] = array_filter($all_orders, function($order) {
            return $order['buyer_id'] == $this->session->userdata('user_id');
        });
        
        // Sort by date descending
        usort($data['orders'], function($a, $b) {
            return strtotime($b['order_date']) - strtotime($a['order_date']);
        });
        
        $data['is_buyer'] = true;
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('buyer/orders', $data);
        $this->load->view('marketplace/footer');
    }
    
    public function order_detail($id) {
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') !== 'buyer') {
            redirect('buyer/login');
        }
        
        $data['title'] = 'Order Details';
        $data['order'] = $this->json_model->get_by_id('orders', $id);
        
        if (!$data['order'] || $data['order']['buyer_id'] != $this->session->userdata('user_id')) {
            show_404();
        }
        
        $data['is_buyer'] = true;
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('buyer/order_detail', $data);
        $this->load->view('marketplace/footer');
    }
    
    private function authenticate_buyer($username, $password) {
        $users = $this->json_model->get_all('users');
        
        foreach ($users as $user) {
            if ($user['username'] === $username && 
                $user['status'] === 'active' && 
                $user['role'] === 'buyer') {
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            }
        }
        return false;
    }
    
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