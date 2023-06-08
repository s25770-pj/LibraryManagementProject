<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("Location: $login_page");
    die;
}

class ArticleRepository {
    private $db;

    public function __construct(Database $db) {
        return $this->db = $db;
    }

    public function get_all_articles() {
        $query = "SELECT article.*, user.user_name AS author_name FROM article JOIN user ON article.user_id = user_id ORDER BY article.updated_at DESC";

        $statement = $this->db->getConnection()->query($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create_article($user_id, $title, $content) {
        $query = "INSERT INTO article (user_id, title, content) VALUES (:user_id, :title, :content)";

        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        $statement->execute();
    }

    public function delete_article($id) {
        $query = "DELETE * FROM article WHERE id = :id";

        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function update_article($id, $title, $content) {
        $query = "UPDATE article SET title = :title, content = :content WHERE id = :id";

        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        $statement->execute();
    }
}

