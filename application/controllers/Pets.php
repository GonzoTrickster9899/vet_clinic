<?php
class Pets extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('json_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Pets';
        $data['pets'] = $this->json_model->get_all('pets');
        $data['customers'] = $this->json_model->get_all('customers');
        
        $this->load->view('templates/header', $data);
        $this->load->view('pets/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add() {
        $data['title'] = 'Add Pet';
        $data['customers'] = $this->json_model->get_all('customers');
        
        $this->form_validation->set_rules('name', 'Pet Name', 'required');
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('species', 'Species', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('pets/add', $data);
            $this->load->view('templates/footer');
        } else {
            $pet = [
                'customer_id' => $this->input->post('customer_id'),
                'name' => $this->input->post('name'),
                'species' => $this->input->post('species'),
                'breed' => $this->input->post('breed'),
                'age' => $this->input->post('age'),
                'weight' => $this->input->post('weight'),
                'medical_history' => $this->input->post('medical_history'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('pets', $pet);
            redirect('pets');
        }
    }
    
    public function edit($id) {
        $data['title'] = 'Edit Pet';
        $data['pet'] = $this->json_model->get_by_id('pets', $id);
        $data['customers'] = $this->json_model->get_all('customers');
        
        if (!$data['pet']) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Pet Name', 'required');
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('species', 'Species', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('pets/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $pet = [
                'customer_id' => $this->input->post('customer_id'),
                'name' => $this->input->post('name'),
                'species' => $this->input->post('species'),
                'breed' => $this->input->post('breed'),
                'age' => $this->input->post('age'),
                'weight' => $this->input->post('weight'),
                'medical_history' => $this->input->post('medical_history')
            ];
            
            $this->json_model->update('pets', $id, $pet);
            redirect('pets');
        }
    }
    
    public function delete($id) {
        $this->json_model->delete('pets', $id);
        redirect('pets');
    }
}