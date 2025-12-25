<?php
class Inventory extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('QRCode');
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
                'sku' => $this->generate_sku(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $item_id = $this->json_model->insert('inventory', $item);
            
            // Generate QR code data
            $this->generate_item_qr($item_id);
            
            $this->session->set_flashdata('success', 'Item added successfully with QR code!');
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
            $this->session->set_flashdata('success', 'Item updated successfully!');
            redirect('inventory');
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/edit', $data);
        $this->load->view('templates/footer');
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
        
        // Load print-friendly QR code view
        $this->load->view('inventory/qrcode_print', $data);
    }
    
    public function print_qrcodes() {
        $data['items'] = $this->json_model->get_all('inventory');
        
        // Generate QR codes for all items
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
        // Generate unique SKU: VET-YYYY-XXXXX
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        return "VET-{$year}-{$random}";
    }
    
    private function get_qr_data($item) {
        // Create JSON data for QR code
        $qr_data = [
            'sku' => isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'],
            'name' => $item['name'],
            'category' => $item['category'],
            'price' => $item['price'],
            'id' => $item['id']
        ];
        
        return json_encode($qr_data);
    }
    
    private function generate_item_qr($item_id) {
        $item = $this->json_model->get_by_id('inventory', $item_id);
        if ($item && !isset($item['sku'])) {
            $sku = $this->generate_sku();
            $this->json_model->update('inventory', $item_id, ['sku' => $sku]);
        }
    }
}
