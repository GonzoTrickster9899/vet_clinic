<?php
class Json_model extends CI_Model {
    
    private $data_dir;
    
    public function __construct() {
        parent::__construct();
        $this->data_dir = APPPATH . 'data/';
        
        if (!is_dir($this->data_dir)) {
            mkdir($this->data_dir, 0777, true);
        }
        
        $this->init_files();
    }
    
    private function init_files() {
        $files = ['customers', 'pets', 'appointments', 'inventory', 'sales'];
        foreach ($files as $file) {
            $filepath = $this->data_dir . $file . '.json';
            if (!file_exists($filepath)) {
                file_put_contents($filepath, json_encode([]));
            }
        }
    }
    
    public function get_all($table) {
        $filepath = $this->data_dir . $table . '.json';
        $data = json_decode(file_get_contents($filepath), true);
        return $data ? $data : [];
    }
    
    public function get_by_id($table, $id) {
        $data = $this->get_all($table);
        foreach ($data as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }
    
    public function insert($table, $record) {
        $data = $this->get_all($table);
        $record['id'] = $this->get_next_id($data);
        $data[] = $record;
        return $this->save_data($table, $data) ? $record['id'] : false;
    }
    
    public function update($table, $id, $record) {
        $data = $this->get_all($table);
        foreach ($data as $key => $item) {
            if ($item['id'] == $id) {
                $data[$key] = array_merge($item, $record);
                $data[$key]['id'] = $id;
                return $this->save_data($table, $data);
            }
        }
        return false;
    }
    
    public function delete($table, $id) {
        $data = $this->get_all($table);
        foreach ($data as $key => $item) {
            if ($item['id'] == $id) {
                unset($data[$key]);
                return $this->save_data($table, array_values($data));
            }
        }
        return false;
    }
    
    private function get_next_id($data) {
        if (empty($data)) return 1;
        $ids = array_column($data, 'id');
        return max($ids) + 1;
    }
    
    private function save_data($table, $data) {
        $filepath = $this->data_dir . $table . '.json';
        return file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }
}