<?php
require_once("Connexion.php");

class Contact {
    private $id;
    private $lastname;
    private $firstname; 
    private $email;
    private $phone;

    public function __construct($id = null, $lastname = "", $firstname = "", $email = "", $phone = "") {
        $this->id = $id;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->phone = $phone;
    }

    // Crud
    public function save() {
        $conn = Connexion::connect();
        $sql = "INSERT INTO contacts (lastname, firstname, email, phone) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$this->lastname, $this->firstname, $this->email, $this->phone]);
    }

    public function update() {
        $conn = Connexion::connect();
        $sql = "UPDATE contacts SET lastname=?, firstname=?, email=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$this->lastname, $this->firstname, $this->email, $this->phone, $this->id]);
    }

    public function delete() {
        $conn = Connexion::connect();
        $sql = "DELETE FROM contacts WHERE id=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public static function getAll() {
        $conn = Connexion::connect();
        $sql = "SELECT * FROM contacts";
        return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $conn = Connexion::connect();
        $sql = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function search($term) {
        $conn = Connexion::connect();
        $sql = "SELECT * FROM contacts WHERE lastname LIKE ? OR firstname LIKE ? OR email LIKE ?";
        $stmt = $conn->prepare($sql);
        $term = "$term%";
        $stmt->execute([$term, $term, $term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Giters seter
    public function getId() { return $this->id; }
    public function getLastname() { return $this->lastname; }
    public function getFirstname() { return $this->firstname; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }

    public function setLastname($lastname) { $this->lastname = $lastname; }
    public function setFirstname($firstname) { $this->firstname = $firstname; }
    public function setEmail($email) { $this->email = $email; }
    public function setPhone($phone) { $this->phone = $phone; }
}
