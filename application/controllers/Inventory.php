<?php
class Inventory extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Inventory';
        $data['items'] = $this->json_model->get_all('inventory');
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add() {
        $data['title'] = 'Add Item';
        
        $this->form_validation->set_rules('name', 'Item Name', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('inventory/add');
            $this->load->view('templates/footer');
        } else {
            $item = [
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'description' => $this->input->post('description'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price'),
                'supplier' => $this->input->post('supplier'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('inventory', $item);
            redirect('inventory');
        }
    }
    
    public function edit($id) {
        $data['title'] = 'Edit Item';
        $data['item'] = $this->json_model->get_by_id('inventory', $id);
        
        if (!$data['item']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $item = [
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'description' => $this->input->post('description'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price'),
                'supplier' => $this->input->post('supplier')
            ];
            
            $this->json_model->update('inventory', $id, $item);
            redirect('inventory');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/edit', $data);
        $this->load->view('templates/footer');
    }
}