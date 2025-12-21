<?php
class Sales extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['title'] = 'Sales';
        $data['sales'] = $this->json_model->get_all('sales');
        $data['customers'] = $this->json_model->get_all('customers');
        $data['inventory'] = $this->json_model->get_all('inventory');
        
        $this->load->view('templates/header', $data);
        $this->load->view('sales/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add() {
        $data['title'] = 'New Sale';
        $data['customers'] = $this->json_model->get_all('customers');
        $data['inventory'] = $this->json_model->get_all('inventory');
        
        if ($this->input->post()) {
            $sale = [
                'customer_id' => $this->input->post('customer_id'),
                'items' => json_decode($this->input->post('items'), true),
                'total' => $this->input->post('total'),
                'payment_method' => $this->input->post('payment_method'),
                'date' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('sales', $sale);
            
            // Update inventory
            foreach ($sale['items'] as $item) {
                $inventory_item = $this->json_model->get_by_id('inventory', $item['id']);
                if ($inventory_item) {
                    $new_qty = $inventory_item['quantity'] - $item['quantity'];
                    $this->json_model->update('inventory', $item['id'], ['quantity' => $new_qty]);
                }
            }
            
            redirect('sales');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('sales/add', $data);
        $this->load->view('templates/footer');
    }
}