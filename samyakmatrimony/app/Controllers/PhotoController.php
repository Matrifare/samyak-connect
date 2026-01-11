<?php
/**
 * Photo Controller
 * Handles photo upload, cropping, reordering, and deletion
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Security;

class PhotoController extends Controller
{
    private string $uploadPath;
    private string $uploadUrl;
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxFileSize = 5 * 1024 * 1024; // 5MB
    private int $maxPhotos = 6;

    public function __construct()
    {
        parent::__construct();
        $this->uploadPath = __DIR__ . '/../../public/uploads/photos/';
        $this->uploadUrl = '/uploads/photos/';
        
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * Photo gallery management page
     */
    public function index(): void
    {
        $this->requireAuth();
        
        $user = $this->session->getUser();
        $photos = $this->getUserPhotos($user['matri_id']);

        $this->render('profile/photos', [
            'title' => 'Manage Photos - Samyak Matrimony',
            'photos' => $photos,
            'maxPhotos' => $this->maxPhotos
        ]);
    }

    /**
     * Get user photos
     */
    private function getUserPhotos(string $matriId): array
    {
        $result = $this->db->selectOne(
            "SELECT photo1, photo2, photo3, photo4, photo5, photo6, photo_order FROM register WHERE matri_id = ?",
            [$matriId]
        );

        $photos = [];
        $order = !empty($result['photo_order']) ? json_decode($result['photo_order'], true) : range(1, 6);

        for ($i = 1; $i <= 6; $i++) {
            $field = 'photo' . $i;
            if (!empty($result[$field])) {
                $photos[] = [
                    'slot' => $i,
                    'filename' => $result[$field],
                    'url' => $this->uploadUrl . $result[$field],
                    'order' => array_search($i, $order) !== false ? array_search($i, $order) : $i - 1
                ];
            }
        }

        // Sort by order
        usort($photos, fn($a, $b) => $a['order'] <=> $b['order']);

        return $photos;
    }

    /**
     * Upload photo (AJAX)
     */
    public function upload(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->json(['success' => false, 'message' => 'No file uploaded or upload error']);
            return;
        }

        $file = $_FILES['photo'];
        $slot = (int) ($this->getPost('slot') ?: $this->getNextAvailableSlot());

        // Validate slot
        if ($slot < 1 || $slot > $this->maxPhotos) {
            $this->json(['success' => false, 'message' => 'Invalid photo slot']);
            return;
        }

        // Validate file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedTypes)) {
            $this->json(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.']);
            return;
        }

        // Validate file size
        if ($file['size'] > $this->maxFileSize) {
            $this->json(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
            return;
        }

        // Generate filename
        $user = $this->session->getUser();
        $extension = $this->getImageExtension($mimeType);
        $filename = $user['matri_id'] . '_' . $slot . '_' . time() . '.' . $extension;

        // Delete old photo if exists
        $this->deletePhotoFile($user['matri_id'], $slot);

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $this->uploadPath . $filename)) {
            $this->json(['success' => false, 'message' => 'Failed to save file']);
            return;
        }

        // Optimize image
        $this->optimizeImage($this->uploadPath . $filename, $mimeType);

        // Update database
        $field = 'photo' . $slot;
        $this->db->update(
            "UPDATE register SET {$field} = ?, updated_at = NOW() WHERE matri_id = ?",
            [$filename, $user['matri_id']]
        );

        // Update session if primary photo
        if ($slot === 1) {
            $this->session->set('user_photo', $filename);
        }

        $this->json([
            'success' => true,
            'message' => 'Photo uploaded successfully!',
            'photo' => [
                'slot' => $slot,
                'filename' => $filename,
                'url' => $this->uploadUrl . $filename
            ]
        ]);
    }

    /**
     * Upload cropped photo (AJAX)
     */
    public function uploadCropped(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }

        $imageData = $this->getPost('image');
        $slot = (int) $this->getPost('slot');

        if (empty($imageData)) {
            $this->json(['success' => false, 'message' => 'No image data received']);
            return;
        }

        // Validate slot
        if ($slot < 1 || $slot > $this->maxPhotos) {
            $this->json(['success' => false, 'message' => 'Invalid photo slot']);
            return;
        }

        // Decode base64 image
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
            $imageType = $matches[1];
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
        } else {
            $this->json(['success' => false, 'message' => 'Invalid image format']);
            return;
        }

        $imageData = base64_decode($imageData);
        if ($imageData === false) {
            $this->json(['success' => false, 'message' => 'Failed to decode image']);
            return;
        }

        // Generate filename
        $user = $this->session->getUser();
        $extension = $imageType === 'jpeg' ? 'jpg' : $imageType;
        $filename = $user['matri_id'] . '_' . $slot . '_' . time() . '.' . $extension;

        // Delete old photo if exists
        $this->deletePhotoFile($user['matri_id'], $slot);

        // Save file
        if (file_put_contents($this->uploadPath . $filename, $imageData) === false) {
            $this->json(['success' => false, 'message' => 'Failed to save file']);
            return;
        }

        // Optimize image
        $mimeType = 'image/' . ($imageType === 'jpg' ? 'jpeg' : $imageType);
        $this->optimizeImage($this->uploadPath . $filename, $mimeType);

        // Update database
        $field = 'photo' . $slot;
        $this->db->update(
            "UPDATE register SET {$field} = ?, updated_at = NOW() WHERE matri_id = ?",
            [$filename, $user['matri_id']]
        );

        if ($slot === 1) {
            $this->session->set('user_photo', $filename);
        }

        $this->json([
            'success' => true,
            'message' => 'Photo saved successfully!',
            'photo' => [
                'slot' => $slot,
                'filename' => $filename,
                'url' => $this->uploadUrl . $filename
            ]
        ]);
    }

    /**
     * Delete photo (AJAX)
     */
    public function delete(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }

        $slot = (int) $this->getPost('slot');

        if ($slot < 1 || $slot > $this->maxPhotos) {
            $this->json(['success' => false, 'message' => 'Invalid photo slot']);
            return;
        }

        $user = $this->session->getUser();

        // Delete file
        $this->deletePhotoFile($user['matri_id'], $slot);

        // Update database
        $field = 'photo' . $slot;
        $this->db->update(
            "UPDATE register SET {$field} = NULL, updated_at = NOW() WHERE matri_id = ?",
            [$user['matri_id']]
        );

        if ($slot === 1) {
            $this->session->remove('user_photo');
        }

        $this->json([
            'success' => true,
            'message' => 'Photo deleted successfully!'
        ]);
    }

    /**
     * Reorder photos (AJAX)
     */
    public function reorder(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }

        $order = $this->getPost('order');

        if (!is_array($order)) {
            $order = json_decode($order, true);
        }

        if (!is_array($order) || empty($order)) {
            $this->json(['success' => false, 'message' => 'Invalid order data']);
            return;
        }

        $user = $this->session->getUser();

        // Validate order contains valid slot numbers
        $validSlots = array_filter($order, fn($s) => is_numeric($s) && $s >= 1 && $s <= $this->maxPhotos);
        
        if (count($validSlots) !== count($order)) {
            $this->json(['success' => false, 'message' => 'Invalid slot numbers']);
            return;
        }

        // Save order
        $this->db->update(
            "UPDATE register SET photo_order = ?, updated_at = NOW() WHERE matri_id = ?",
            [json_encode(array_map('intval', $order)), $user['matri_id']]
        );

        $this->json([
            'success' => true,
            'message' => 'Photo order updated!'
        ]);
    }

    /**
     * Set primary photo (AJAX)
     */
    public function setPrimary(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }

        $slot = (int) $this->getPost('slot');

        if ($slot < 1 || $slot > $this->maxPhotos) {
            $this->json(['success' => false, 'message' => 'Invalid photo slot']);
            return;
        }

        $user = $this->session->getUser();
        $photos = $this->getUserPhotos($user['matri_id']);

        // Find the photo to make primary
        $targetPhoto = null;
        $currentPrimary = null;

        foreach ($photos as $photo) {
            if ($photo['slot'] === $slot) {
                $targetPhoto = $photo;
            }
            if ($photo['slot'] === 1) {
                $currentPrimary = $photo;
            }
        }

        if (!$targetPhoto) {
            $this->json(['success' => false, 'message' => 'Photo not found']);
            return;
        }

        // Swap photos in database
        $targetField = 'photo' . $slot;
        
        $this->db->update(
            "UPDATE register SET 
                photo1 = {$targetField},
                {$targetField} = photo1,
                updated_at = NOW()
             WHERE matri_id = ?",
            [$user['matri_id']]
        );

        // Update session
        $this->session->set('user_photo', $targetPhoto['filename']);

        $this->json([
            'success' => true,
            'message' => 'Primary photo updated!'
        ]);
    }

    /**
     * Get next available photo slot
     */
    private function getNextAvailableSlot(): int
    {
        $user = $this->session->getUser();
        $result = $this->db->selectOne(
            "SELECT photo1, photo2, photo3, photo4, photo5, photo6 FROM register WHERE matri_id = ?",
            [$user['matri_id']]
        );

        for ($i = 1; $i <= $this->maxPhotos; $i++) {
            if (empty($result['photo' . $i])) {
                return $i;
            }
        }

        return 1; // Overwrite first if all slots full
    }

    /**
     * Delete photo file from disk
     */
    private function deletePhotoFile(string $matriId, int $slot): void
    {
        $field = 'photo' . $slot;
        $result = $this->db->selectOne(
            "SELECT {$field} FROM register WHERE matri_id = ?",
            [$matriId]
        );

        if (!empty($result[$field])) {
            $filePath = $this->uploadPath . $result[$field];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    /**
     * Optimize image (resize if too large, compress)
     */
    private function optimizeImage(string $filePath, string $mimeType): void
    {
        $maxWidth = 1200;
        $maxHeight = 1200;
        $quality = 85;

        list($width, $height) = getimagesize($filePath);

        if ($width <= $maxWidth && $height <= $maxHeight) {
            return; // No need to resize
        }

        // Calculate new dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int) ($width * $ratio);
        $newHeight = (int) ($height * $ratio);

        // Create image resource
        switch ($mimeType) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($filePath);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($filePath);
                break;
            case 'image/webp':
                $source = imagecreatefromwebp($filePath);
                break;
            default:
                return;
        }

        if (!$source) {
            return;
        }

        // Create resized image
        $destination = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
            imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save optimized image
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($destination, $filePath, $quality);
                break;
            case 'image/png':
                imagepng($destination, $filePath, 8);
                break;
            case 'image/gif':
                imagegif($destination, $filePath);
                break;
            case 'image/webp':
                imagewebp($destination, $filePath, $quality);
                break;
        }

        imagedestroy($source);
        imagedestroy($destination);
    }

    /**
     * Get image extension from MIME type
     */
    private function getImageExtension(string $mimeType): string
    {
        return match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => 'jpg'
        };
    }
}
