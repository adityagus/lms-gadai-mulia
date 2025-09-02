<?php

// File untuk testing API update course dengan upload gambar
// Jalankan dengan: php test_update_course.php

echo "=== Testing API Update Course dengan Upload Gambar ===\n\n";

// Konfigurasi
$baseUrl = 'http://localhost:80/lmsgadai/public'; // Sesuaikan dengan URL Laravel Anda
$courseId = 1; // ID course yang akan di-update (ganti sesuai kebutuhan)

// Data yang akan di-update
$updateData = [
    'name' => 'Course Updated dengan Gambar Baru',
    'tagline' => 'Tagline course yang sudah diupdate',
    'description' => 'Deskripsi course yang sudah diupdate dengan gambar baru',
    'category_id' => 1,
    'is_popular' => true,
    'students' => 'null',
    'details' => 'null'
];

// Path ke file gambar untuk testing (buat file dummy atau gunakan gambar yang ada)
$imagePath = __DIR__ . '/test_image.jpg';

// Buat file gambar dummy jika belum ada
if (!file_exists($imagePath)) {
    echo "Membuat file gambar dummy untuk testing...\n";
    
    // Buat gambar sederhana 100x100 pixel
    $image = imagecreate(100, 100);
    $backgroundColor = imagecolorallocate($image, 255, 255, 255); // putih
    $textColor = imagecolorallocate($image, 0, 0, 0); // hitam
    
    // Tambahkan text
    imagestring($image, 5, 10, 40, 'TEST', $textColor);
    
    // Simpan sebagai JPEG
    imagejpeg($image, $imagePath, 90);
    imagedestroy($image);
    
    echo "File gambar dummy berhasil dibuat: $imagePath\n\n";
}

// Fungsi untuk upload dengan cURL
function updateCourseWithImage($url, $courseId, $data, $imagePath) {
    $ch = curl_init();
    
    // Siapkan data untuk form-data
    $postData = $data;
    
    // Tambahkan file gambar
    if (file_exists($imagePath)) {
        $postData['thumbnail'] = new CURLFile($imagePath, 'image/jpeg', 'test_image.jpg');
    }
    
    // Tambahkan method override untuk Laravel
    $postData['_method'] = 'PUT';
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url . '/api/courses/' . $courseId,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            // Jangan set Content-Type untuk multipart/form-data, biarkan cURL yang handle
        ],
        CURLOPT_VERBOSE => true,
        CURLOPT_STDERR => fopen('php://temp', 'w+'),
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    return [
        'response' => $response,
        'http_code' => $httpCode,
        'error' => $error
    ];
}

echo "Mengirim request update course dengan gambar baru...\n";
echo "URL: $baseUrl/api/courses/$courseId\n";
echo "Method: POST (dengan _method=PUT)\n";
echo "Data yang dikirim:\n";
print_r($updateData);
echo "\nFile gambar: $imagePath\n\n";

// Kirim request
$result = updateCourseWithImage($baseUrl, $courseId, $updateData, $imagePath);

echo "=== HASIL RESPONSE ===\n";
echo "HTTP Code: " . $result['http_code'] . "\n";

if ($result['error']) {
    echo "cURL Error: " . $result['error'] . "\n";
} else {
    echo "Response Body:\n";
    
    // Coba decode JSON response
    $responseData = json_decode($result['response'], true);
    
    if ($responseData) {
        echo json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        
        // Analisis response
        if ($result['http_code'] == 200) {
            echo "\n✅ UPDATE BERHASIL!\n";
            
            if (isset($responseData['data'])) {
                $course = $responseData['data'];
                echo "Course Name: " . $course['name'] . "\n";
                echo "Tagline: " . $course['tagline'] . "\n";
                echo "Description: " . $course['description'] . "\n";
                
                if (isset($course['thumbnail'])) {
                    echo "Thumbnail Path: " . $course['thumbnail'] . "\n";
                }
                
                if (isset($course['thumbnail_url'])) {
                    echo "Thumbnail URL: " . $course['thumbnail_url'] . "\n";
                }
            }
        } else {
            echo "\n❌ UPDATE GAGAL!\n";
            
            if (isset($responseData['message'])) {
                echo "Error Message: " . $responseData['message'] . "\n";
            }
        }
    } else {
        echo "Raw Response:\n";
        echo $result['response'] . "\n";
    }
}

echo "\n=== TESTING SELESAI ===\n";

// Fungsi untuk testing tanpa upload gambar (optional)
function testUpdateWithoutImage($url, $courseId, $data) {
    echo "\n=== Testing Update Tanpa Upload Gambar ===\n";
    
    $ch = curl_init();
    
    // Data untuk update tanpa gambar
    $postData = $data;
    $postData['_method'] = 'PUT';
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url . '/api/courses/' . $courseId,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
        ],
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    echo "HTTP Code: $httpCode\n";
    if ($error) {
        echo "Error: $error\n";
    } else {
        $responseData = json_decode($response, true);
        if ($responseData) {
            echo json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        } else {
            echo "Raw Response: $response\n";
        }
    }
}

// Uncomment baris berikut untuk testing update tanpa upload gambar
// testUpdateWithoutImage($baseUrl, $courseId, $updateData);

?>
