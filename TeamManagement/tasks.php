<?php

class TaskRepository {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAllTasks() {
        $query = "SELECT * FROM tasks";
        $stmt = $this->db->getConnection()->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($title, $completed) {
        $query = "INSERT INTO tasks (title, completed) VALUES (:title, :completed)";
        $statement = $this->db->getConnection()->prepare($query);

        $statement->bindParam(':title', $title);
        $statement->bindParam(':completed', $completed);

        $statement->execute();

        return $statement->rowCount();
    }

    public function deleteTask($taskId) {
        $query = "DELETE FROM tasks WHERE id = :id";
        $statement = $this->db->getConnection()->prepare($query);

        $statement->bindParam(':id', $taskId);

        $statement->execute();

        return $statement->rowCount();
    }

    public function updateTask($taskId, $title, $completed) {
        $query = "UPDATE tasks SET title = :title, completed = :completed WHERE id = :id";
        $statement = $this->db->getConnection()->prepare($query);

        $statement->bindParam(':title', $title);
        $statement->bindParam(':completed', $completed);
        $statement->bindParam(':id', $taskId);

        $statement->execute();

        return $statement->rowCount();
    }
}