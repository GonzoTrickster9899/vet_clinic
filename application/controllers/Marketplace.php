<?php
class Marketplace extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
    }
    
    public function index() {
        $data['title'] = 'Shop - Vet Clinic & Pet Shop';
        
        // Get all inventory items that are in stock
        $all_items = $this->json_model->get_all('inventory');
        $data['items'] = array_filter($all_items, function($item) {
            return $item['quantity'] > 0;
        });
        
        // Get categories for filter
        $data['categories'] = array_unique(array_column($all_items, 'category'));
        
        // Check if user is logged in as buyer
        $data['is_buyer'] = ($this->session->userdata('logged_in') && 
                             $this->session->userdata('role') === 'buyer');
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('marketplace/index', $data);
        $this->load->view('marketplace/footer');
    }
    
    public function product($id) {
        $data['title'] = 'Product Details';
        $data['item'] = $this->json_model->get_by_id('inventory', $id);
        
        if (!$data['item']) {
            show_404();
        }
        
        $data['is_buyer'] = ($this->session->userdata('logged_in') && 
                             $this->session->userdata('role') === 'buyer');
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('marketplace/product', $data);
        $this->load->view('marketplace/footer');
    }
    
    public function add_to_cart() {
        $item_id = $this->input->post('item_id');
        $quantity = $this->input->post('quantity');
        
        $item = $this->json_model->get_by_id('inventory', $item_id);
        
        if ($item && $quantity > 0 && $quantity <= $item['quantity']) {
            $data = array(
                'id'      => $item['id'],
                'qty'     => $quantity,
                'price'   => $item['price'],
                'name'    => $item['name'],
                'options' => array(
                    'image' => isset($item['image']) ? $item['image'] : '',
                    'category' => $item['category'],
                    'sku' => isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id']
                )
            );
            
            $this->cart->insert($data);
            $this->session->set_flashdata('success', 'Item added to cart!');
        } else {
            $this->session->set_flashdata('error', 'Invalid quantity or item out of stock');
        }
        
        redirect('marketplace/cart');
    }
    
    public function cart() {
        $data['title'] = 'Shopping Cart';
        $data['is_buyer'] = ($this->session->userdata('logged_in') && 
                             $this->session->userdata('role') === 'buyer');
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('marketplace/cart', $data);
        $this->load->view('marketplace/footer');
    }
    
    public function update_cart() {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        
        if ($qty > 0) {
            $data = array('rowid' => $rowid, 'qty' => $qty);
            $this->cart->update($data);
            $this->session->set_flashdata('success', 'Cart updated!');
        }
        
        redirect('marketplace/cart');
    }
    
    public function remove_item($rowid) {
        $this->cart->remove($rowid);
        $this->session->set_flashdata('success', 'Item removed from cart');
        redirect('marketplace/cart');
    }
    
    public function clear_cart() {
        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Cart cleared');
        redirect('marketplace/cart');
    }
    
    public function checkout() {
        // Must be logged in as buyer
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') !== 'buyer') {
            $this->session->set_flashdata('error', 'Please login as a buyer to checkout');
            redirect('buyer/login');
        }
        
        if ($this->cart->total_items() == 0) {
            $this->session->set_flashdata('error', 'Your cart is empty');
            redirect('marketplace');
        }
        
        $data['title'] = 'Checkout';
        $data['is_buyer'] = true;
        
        $this->load->view('marketplace/header', $data);
        $this->load->view('marketplace/checkout', $data);
        $this->load->view('marketplace/footer');
    }
    
    public function place_order() {
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') !== 'buyer') {
            redirect('buyer/login');
        }
        
        if ($this->cart->total_items() == 0) {
            redirect('marketplace');
        }
        
        // Create order
        $order = [
            'buyer_id' => $this->session->userdata('user_id'),
            'buyer_name' => $this->session->userdata('full_name'),
            'buyer_email' => $this->session->userdata('email'),
            'items' => [],
            'total' => $this->cart->total(),
            'payment_method' => $this->input->post('payment_method'),
            'delivery_address' => $this->input->post('delivery_address'),
            'contact_number' => $this->input->post('contact_number'),
            'notes' => $this->input->post('notes'),
            'status' => 'pending',
            'order_date' => date('Y-m-d H:i:s')
        ];
        
        // Add cart items to order
        foreach ($this->cart->contents() as $item) {
            $order['items'][] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
                'sku' => $item['options']['sku']
            ];
            
            // Update inventory
            $inventory_item = $this->json_model->get_by_id('inventory', $item['id']);
            if ($inventory_item) {
                $new_qty = $inventory_item['quantity'] - $item['qty'];
                $this->json_model->update('inventory', $item['id'], ['quantity' => $new_qty]);
            }
        }
        
        $order_id = $this->json_model->insert('orders', $order);
        
        // Clear cart
        $this->cart->destroy();
        
        $this->session->set_flashdata('success', 'Order placed successfully! Order ID: ' . $order_id);
        redirect('buyer/orders');
    }
}