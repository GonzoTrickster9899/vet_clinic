<?php
class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_auth();
    }
    
    private function check_auth() {
        // Get the current controller and method
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        
        // Allow Auth controller without login
        if ($controller === 'auth') {
            return;
        }
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }
    
    // Helper method to check if user has specific role
    protected function require_role($role) {
        if ($this->session->userdata('role') !== $role) {
            show_error('You do not have permission to access this page', 403);
        }
    }
    
    // Helper method to check if user is admin
    protected function is_admin() {
        return $this->session->userdata('role') === 'admin';
    }
}