<?php
// เชื่อมต่อฐานข้อมูล MySQL
$host = 'db'; // ชื่อ Host ของ MySQL ที่กำหนดใน docker-compose.yml
$dbname = 'mybooks_db'; // ชื่อฐานข้อมูลที่สร้างใน docker-compose.yml
$username = 'user'; // ชื่อผู้ใช้ MySQL ที่กำหนดใน docker-compose.yml
$password = 'password'; // รหัสผ่าน MySQL ที่กำหนดใน docker-compose.yml

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = $_POST['book_name'];
    $description = $_POST['description'];

    // สร้าง SQL query เพื่อเพิ่มข้อมูลใหม่ในตาราง books
    $sql = "INSERT INTO books (book_name, description) VALUES (:book_name, :description)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':book_name', $bookName);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
        echo "Book added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
