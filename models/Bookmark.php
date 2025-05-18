<?php

require_once __DIR__ . '/../db/Database.php'; 

class Bookmark {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create($title, $url) {
        $query = "INSERT INTO bookmarks (title, url) VALUES (:title, :url)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':url', $url);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM bookmarks ORDER BY date_added DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $query = "SELECT * FROM bookmarks WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $url) {
        $query = "UPDATE bookmarks SET title = :title, url = :url WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':url', $url);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM bookmarks WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
