<?php
class Customers extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('json_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Customers';
        $data['customers'] = $this->json_model->get_all('customers');
        
        $this->load->view('templates/header', $data);
        $this->load->view('customers/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add() {
        $data['title'] = 'Add Customer';
        
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('customers/add');
            $this->load->view('templates/footer');
        } else {
            $customer = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('customers', $customer);
            redirect('customers');
        }
    }
    
    public function edit($id) {
        $data['title'] = 'Edit Customer';
        $data['customer'] = $this->json_model->get_by_id('customers', $id);
        
        if (!$data['customer']) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('customers/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $customer = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            ];
            
            $this->json_model->update('customers', $id, $customer);
            redirect('customers');
        }
    }
    
    public function delete($id) {
        $this->json_model->delete('customers', $id);
        redirect('customers');
    }
}