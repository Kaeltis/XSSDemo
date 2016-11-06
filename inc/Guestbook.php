<?php

class Guestbook
{
    private $db;
    private $sanitize = false;

    /**
     * Guestbook constructor.
     */
    public function __construct()
    {
        try {
            $this->db = new PDO('sqlite:guestbook.sqlite');
            $this->db->exec("CREATE TABLE IF NOT EXISTS users(
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    username TEXT NOT NULL,
                    password TEXT NOT NULL,
                    avatar INTEGER NOT NULL)");
            $this->db->exec("CREATE TABLE IF NOT EXISTS entries(
                    id INTEGER PRIMARY KEY AUTOINCREMENT, 
                    username TEXT NOT NULL,
                    message TEXT NOT NULL,
                    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                    )");
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public function truncateEntries()
    {
        $this->db->exec("DELETE FROM entries");
    }

    public function checkUser($username, $password = null)
    {
        if (is_null($password)) {
            $query = $this->db->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
            $query->bindValue(':username', $username);
            $query->execute();

            return $query->fetchColumn() > 0;
        } else {
            $query = $this->db->prepare('SELECT password FROM users WHERE username = :username');
            $query->bindValue(':username', $username);
            $query->execute();

            return password_verify($password, $query->fetchColumn());
        }
    }

    public function createUser($username, $password)
    {
        if ($this->checkUser($username)) {
            return false;
        }

        $query = $this->db->prepare("INSERT INTO users (username, password, avatar) VALUES (:username, :password, :avatar)");
        $query->bindValue(':username', $username);
        $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $query->bindValue(':avatar', rand(1, 10));
        $query->execute();

        return true;
    }

    public function createEntry($username, $message)
    {
        $query = $this->db->prepare("INSERT INTO entries (username, message) VALUES (:username, :message)");
        $query->bindValue(':username', $username);
        $query->bindValue(':message', $message);
        $query->execute();

        return true;
    }

    public function getAvatar($username)
    {
        $query = $this->db->prepare("SELECT avatar FROM users WHERE username= :username");
        $query->bindValue(':username', $username);
        $query->execute();

        return $query->fetchColumn();
    }

    public function getEntries()
    {
        $query = $this->db->prepare("SELECT * FROM entries");
        $query->execute();

        return $query->fetchAll();
    }

    public function sanitizeString($input)
    {
        if ($this->sanitize) {
            return htmlspecialchars($input);
        } else {
            return $input;
        }
    }

}