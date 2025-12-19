<?php
class Appointments extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('json_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Appointments';
        $data['appointments'] = $this->json_model->get_all('appointments');
        $data['pets'] = $this->json_model->get_all('pets');
        $data['customers'] = $this->json_model->get_all('customers');
        
        $this->load->view('templates/header', $data);
        $this->load->view('appointments/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add() {
        $data['title'] = 'Add Appointment';
        $data['pets'] = $this->json_model->get_all('pets');
        $data['customers'] = $this->json_model->get_all('customers');
        
        $this->form_validation->set_rules('pet_id', 'Pet', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('appointments/add', $data);
            $this->load->view('templates/footer');
        } else {
            $appointment = [
                'pet_id' => $this->input->post('pet_id'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'reason' => $this->input->post('reason'),
                'status' => 'scheduled',
                'notes' => '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('appointments', $appointment);
            redirect('appointments');
        }
    }
    
    public function edit($id) {
        $data['title'] = 'Edit Appointment';
        $data['appointment'] = $this->json_model->get_by_id('appointments', $id);
        $data['pets'] = $this->json_model->get_all('pets');
        $data['customers'] = $this->json_model->get_all('customers');
        
        if (!$data['appointment']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $appointment = [
                'pet_id' => $this->input->post('pet_id'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'reason' => $this->input->post('reason'),
                'status' => $this->input->post('status'),
                'notes' => $this->input->post('notes')
            ];
            
            $this->json_model->update('appointments', $id, $appointment);
            redirect('appointments');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('appointments/edit', $data);
        $this->load->view('templates/footer');
    }
}
