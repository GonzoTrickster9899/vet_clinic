<?php
class Orders extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['title'] = 'Orders Management';
        $data['orders'] = $this->json_model->get_all('orders');
        
        // Sort by date descending
        usort($data['orders'], function($a, $b) {
            return strtotime($b['order_date']) - strtotime($a['order_date']);
        });
        
        $this->load->view('templates/header', $data);
        $this->load->view('orders/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function view($id) {
        $data['title'] = 'Order Details';
        $data['order'] = $this->json_model->get_by_id('orders', $id);
        
        if (!$data['order']) {
            show_404();
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('orders/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_status($id) {
        $status = $this->input->post('status');
        
        if (in_array($status, ['pending', 'processing', 'completed', 'cancelled'])) {
            $this->json_model->update('orders', $id, ['status' => $status]);
            $this->session->set_flashdata('success', 'Order status updated!');
        }
        
        redirect('orders/view/' . $id);
    }
}