<?php
class QRCode {
    
    /**
     * Generate QR Code using Google Charts API
     * Returns the image URL
     */
    public function generate($data, $size = 200) {
        $data = urlencode($data);
        return "https://quickchart.io/chart?chs={$size}x{$size}&cht=qr&chl={$data}&choe=UTF-8";
    }
    
    /**
     * Generate QR Code and save as file
     */
    public function save($data, $filename, $size = 300) {
        $url = $this->generate($data, $size);
        $image_data = @file_get_contents($url);
        
        if ($image_data) {
            return file_put_contents($filename, $image_data);
        }
        return false;
    }
    
    /**
     * Generate QR Code with custom styling using phpqrcode library alternative
     * This is a backup method if Google Charts is unavailable
     */
    public function generate_local($data, $size = 5) {
        // This would require phpqrcode library
        // For now, we'll use Google Charts API as it's simpler
        return $this->generate($data, $size * 50);
    }
}