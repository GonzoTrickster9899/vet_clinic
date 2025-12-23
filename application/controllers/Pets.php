<?php
class Pets extends MY_Controller {
    
    private $upload_path = './assets/images/pets/';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->check_upload_directory();
    }
    
    private function check_upload_directory() {
        // Check if directory exists and is writable
        if (!is_dir($this->upload_path)) {
            $this->session->set_flashdata('error', 
                'Upload directory does not exist. Please contact administrator to create: ' . $this->upload_path);
            return false;
        }
        
        if (!is_writable($this->upload_path)) {
            $this->session->set_flashdata('error', 
                'Upload directory is not writable. Please contact administrator to fix permissions.');
            return false;
        }
        
        return true;
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
            // Handle image upload
            $image_name = $this->upload_pet_image();
            
            $pet = [
                'customer_id' => $this->input->post('customer_id'),
                'name' => $this->input->post('name'),
                'species' => $this->input->post('species'),
                'breed' => $this->input->post('breed'),
                'age' => $this->input->post('age'),
                'weight' => $this->input->post('weight'),
                'medical_history' => $this->input->post('medical_history'),
                'image' => $image_name,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('pets', $pet);
            $this->session->set_flashdata('success', 'Pet added successfully!');
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
            
            // Handle new image upload
            $new_image = $this->upload_pet_image();
            if ($new_image) {
                // Delete old image if exists
                if (isset($data['pet']['image']) && !empty($data['pet']['image'])) {
                    $old_image_path = $this->upload_path . $data['pet']['image'];
                    if (file_exists($old_image_path)) {
                        @unlink($old_image_path);
                    }
                }
                $pet['image'] = $new_image;
            }
            
            $this->json_model->update('pets', $id, $pet);
            $this->session->set_flashdata('success', 'Pet updated successfully!');
            redirect('pets');
        }
    }
    
    public function delete($id) {
        $pet = $this->json_model->get_by_id('pets', $id);
        
        // Delete pet image if exists
        if ($pet && isset($pet['image']) && !empty($pet['image'])) {
            $image_path = $this->upload_path . $pet['image'];
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
        }
        
        $this->json_model->delete('pets', $id);
        $this->session->set_flashdata('success', 'Pet deleted successfully!');
        redirect('pets');
    }
    
    public function delete_image($id) {
        $pet = $this->json_model->get_by_id('pets', $id);
        
        if ($pet && isset($pet['image']) && !empty($pet['image'])) {
            $image_path = $this->upload_path . $pet['image'];
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            
            $this->json_model->update('pets', $id, ['image' => '']);
            $this->session->set_flashdata('success', 'Pet image deleted successfully!');
        }
        
        redirect('pets/edit/' . $id);
    }
    
    private function upload_pet_image() {
        if (!empty($_FILES['pet_image']['name'])) {
            // Check if upload directory exists and is writable
            if (!is_dir($this->upload_path)) {
                $this->session->set_flashdata('error', 'Upload directory does not exist!');
                return '';
            }
            
            if (!is_writable($this->upload_path)) {
                $this->session->set_flashdata('error', 'Upload directory is not writable! Check permissions.');
                return '';
            }
            
            $config['upload_path'] = $this->upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('pet_image')) {
                $upload_data = $this->upload->data();
                return $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', 'Upload failed: ' . $error);
                return '';
            }
        }
        return '';
    }
    
    public function view($id) {
        $data['title'] = 'Pet Details';
        $data['pet'] = $this->json_model->get_by_id('pets', $id);
        $data['customers'] = $this->json_model->get_all('customers');
        
        if (!$data['pet']) {
            show_404();
        }
        
        // Get owner details
        $data['owner'] = null;
        foreach ($data['customers'] as $customer) {
            if ($customer['id'] == $data['pet']['customer_id']) {
                $data['owner'] = $customer;
                break;
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('pets/view', $data);
        $this->load->view('templates/footer');
    }
}