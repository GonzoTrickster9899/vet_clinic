<?php
class Inventory extends MY_Controller {
    
    private $upload_path = './assets/images/inventory/';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('QRCode');
        $this->init_upload_directory();
    }
    
    private function init_upload_directory() {
        if (!is_dir($this->upload_path)) {
            @mkdir($this->upload_path, 0777, true);
        }
    }
    
    private function check_upload_directory() {
        if (!is_dir($this->upload_path)) {
            $this->session->set_flashdata('error', 
                'Upload directory does not exist. Please contact administrator.');
            return false;
        }
        
        if (!is_writable($this->upload_path)) {
            $this->session->set_flashdata('error', 
                'Upload directory is not writable. Please check permissions.');
            return false;
        }
        
        return true;
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
            // Handle image upload
            $image_name = $this->upload_item_image();
            
            $item = [
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'description' => $this->input->post('description'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price'),
                'supplier' => $this->input->post('supplier'),
                'sku' => $this->generate_sku(),
                'image' => $image_name,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->json_model->insert('inventory', $item);
            $this->session->set_flashdata('success', 'Item added successfully!');
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
            
            // Handle new image upload
            $new_image = $this->upload_item_image();
            if ($new_image) {
                // Delete old image if exists
                if (isset($data['item']['image']) && !empty($data['item']['image'])) {
                    $old_image_path = $this->upload_path . $data['item']['image'];
                    if (file_exists($old_image_path)) {
                        @unlink($old_image_path);
                    }
                }
                $item['image'] = $new_image;
            }
            
            $this->json_model->update('inventory', $id, $item);
            $this->session->set_flashdata('success', 'Item updated successfully!');
            redirect('inventory');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete($id) {
        $item = $this->json_model->get_by_id('inventory', $id);
        
        // Delete item image if exists
        if ($item && isset($item['image']) && !empty($item['image'])) {
            $image_path = $this->upload_path . $item['image'];
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
        }
        
        $this->json_model->delete('inventory', $id);
        $this->session->set_flashdata('success', 'Item deleted successfully!');
        redirect('inventory');
    }
    
    public function delete_image($id) {
        $item = $this->json_model->get_by_id('inventory', $id);
        
        if ($item && isset($item['image']) && !empty($item['image'])) {
            $image_path = $this->upload_path . $item['image'];
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            
            $this->json_model->update('inventory', $id, ['image' => '']);
            $this->session->set_flashdata('success', 'Item image deleted successfully!');
        }
        
        redirect('inventory/edit/' . $id);
    }
    
    private function upload_item_image() {
        if (!empty($_FILES['item_image']['name'])) {
            if (!$this->check_upload_directory()) {
                return '';
            }
            
            $config['upload_path'] = $this->upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('item_image')) {
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
        $data['title'] = 'Item Details';
        $data['item'] = $this->json_model->get_by_id('inventory', $id);
        
        if (!$data['item']) {
            show_404();
        }
        
        // Generate QR code URL
        $qr_data = $this->get_qr_data($data['item']);
        $data['qr_code_url'] = $this->qrcode->generate($qr_data, 300);
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function qrcode($id) {
        $item = $this->json_model->get_by_id('inventory', $id);
        
        if (!$item) {
            show_404();
        }
        
        $data['item'] = $item;
        $qr_data = $this->get_qr_data($item);
        $data['qr_code_url'] = $this->qrcode->generate($qr_data, 300);
        
        $this->load->view('inventory/qrcode_print', $data);
    }
    
    public function print_qrcodes() {
        $data['items'] = $this->json_model->get_all('inventory');
        
        foreach ($data['items'] as &$item) {
            $qr_data = $this->get_qr_data($item);
            $item['qr_code_url'] = $this->qrcode->generate($qr_data, 200);
        }
        
        $this->load->view('inventory/qrcode_print_all', $data);
    }
    
    public function scan() {
        $data['title'] = 'Scan QR Code';
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/scan', $data);
        $this->load->view('templates/footer');
    }
    
    public function lookup() {
        $sku = $this->input->post('sku');
        
        if ($sku) {
            $items = $this->json_model->get_all('inventory');
            
            foreach ($items as $item) {
                if (isset($item['sku']) && $item['sku'] === $sku) {
                    echo json_encode([
                        'success' => true,
                        'item' => $item,
                        'view_url' => base_url('inventory/view/' . $item['id'])
                    ]);
                    return;
                }
            }
        }
        
        echo json_encode(['success' => false, 'message' => 'Item not found']);
    }
    
    private function generate_sku() {
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        return "VET-{$year}-{$random}";
    }
    
    private function get_qr_data($item) {
        $qr_data = [
            'sku' => isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'],
            'name' => $item['name'],
            'category' => $item['category'],
            'price' => $item['price'],
            'id' => $item['id']
        ];
        
        return json_encode($qr_data);
    }
}