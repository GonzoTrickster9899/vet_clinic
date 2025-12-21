<?php
class Dashboard extends MY_Controller { // Changed from CI_Controller
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['title'] = 'Dashboard';
        $data['customers_count'] = count($this->json_model->get_all('customers'));
        $data['pets_count'] = count($this->json_model->get_all('pets'));
        $data['appointments_today'] = $this->get_today_appointments();
        $data['low_stock_items'] = $this->get_low_stock_items();
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
    
    private function get_today_appointments() {
        $appointments = $this->json_model->get_all('appointments');
        $today = date('Y-m-d');
        $count = 0;
        foreach ($appointments as $apt) {
            if ($apt['date'] == $today) $count++;
        }
        return $count;
    }
    
    private function get_low_stock_items() {
        $inventory = $this->json_model->get_all('inventory');
        $low_stock = [];
        foreach ($inventory as $item) {
            if ($item['quantity'] < 10) {
                $low_stock[] = $item;
            }
        }
        return $low_stock;
    }
}