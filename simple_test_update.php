<?php

// Simple test untuk API Update Course dengan gambar
echo "=== Simple Test Update Course API ===\n\n";

$url = 'http://localhost:80/lmsgadai/public/api/courses/1'; // Ganti ID sesuai kebutuhan
$imagePath = __DIR__ . '/sample_image.jpg';

// Buat sample image jika belum ada
if (!file_exists($imagePath)) {
    // Download sample image atau buat dummy
    $imageData = base64_decode('/9j/4AAQSkZJRgABAQEAAAAAAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/AB8A');
    file_put_contents($imagePath, $imageData);
    echo "Sample image created: $imagePath\n\n";
}

// Data untuk update
$data = [
    'name' => 'Course Diupdate ' . date('Y-m-d H:i:s'),
    'tagline' => 'Tagline baru untuk testing',
    'description' => 'Deskripsi course yang sudah diupdate dengan gambar baru pada ' . date('Y-m-d H:i:s'),
    'category_id' => 1,
    'is_popular' => 1,
    'students' => 'null',
    'details' => 'null',
    '_method' => 'PUT'
];

echo "Sending update request...\n";
echo "URL: $url\n";
echo "Image: $imagePath\n\n";

// Initialize cURL
$ch = curl_init();

// Prepare multipart data
$postData = $data;
if (file_exists($imagePath)) {
    $postData['thumbnail'] = new CURLFile($imagePath, 'image/jpeg', 'updated_thumbnail.jpg');
}

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "=== RESPONSE ===\n";
echo "HTTP Code: $httpCode\n";

if ($error) {
    echo "cURL Error: $error\n";
} else {
    echo "Response:\n";
    $decoded = json_decode($response, true);
    
    if ($decoded) {
        echo json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        if ($httpCode == 200 && isset($decoded['data'])) {
            echo "\n\n✅ SUCCESS! Course updated successfully\n";
            echo "New name: " . $decoded['data']['name'] . "\n";
            echo "Thumbnail: " . ($decoded['data']['thumbnail'] ?? 'No thumbnail') . "\n";
            
            if (isset($decoded['data']['thumbnail_url'])) {
                echo "Thumbnail URL: " . $decoded['data']['thumbnail_url'] . "\n";
            }
        } else {
            echo "\n\n❌ FAILED! HTTP Code: $httpCode\n";
        }
    } else {
        echo $response;
    }
}

echo "\n\n=== TEST COMPLETED ===\n";

?>
