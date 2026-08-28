<?php
/**
 * ThreadPixel - Secure File Upload Handler
 */

class FileUpload {
    private $allowedTypes;
    private $maxSize;
    private $uploadDir;

    public function __construct($type = 'artwork') {
        $this->maxSize = MAX_FILE_SIZE;
        $this->uploadDir = ROOT_PATH . '/public/assets/uploads/';

        switch ($type) {
            case 'embroidery':
                $this->allowedTypes = ALLOWED_EMBROIDERY_TYPES;
                break;
            case 'image':
                $this->allowedTypes = ALLOWED_IMAGE_TYPES;
                break;
            case 'artwork':
            default:
                $this->allowedTypes = array_merge(ALLOWED_ARTWORK_TYPES, ALLOWED_EMBROIDERY_TYPES);
                break;
        }
    }

    public function upload($file, $subDir = '') {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'File upload failed. Please try again.'];
        }

        // Check file size
        if ($file['size'] > $this->maxSize) {
            $maxMB = $this->maxSize / (1024 * 1024);
            return ['success' => false, 'error' => "File size exceeds the maximum limit of {$maxMB}MB."];
        }

        // Get file extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedTypes)) {
            return ['success' => false, 'error' => 'File type not allowed. Allowed types: ' . implode(', ', $this->allowedTypes)];
        }

        // Generate safe filename
        $safeName = bin2hex(random_bytes(16)) . '.' . $ext;

        // Create subdirectory if needed
        $targetDir = $this->uploadDir . ($subDir ? $subDir . '/' : '');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . $safeName;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $relativePath = 'assets/uploads/' . ($subDir ? $subDir . '/' : '') . $safeName;
            return [
                'success' => true,
                'file_name' => $file['name'],
                'file_path' => $relativePath,
                'file_size' => $file['size'],
                'extension' => $ext
            ];
        }

        return ['success' => false, 'error' => 'Failed to save the uploaded file.'];
    }

    public function uploadMultiple($files, $subDir = '') {
        $results = [];
        $fileCount = count($files['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];
            $results[] = $this->upload($file, $subDir);
        }
        return $results;
    }
}
