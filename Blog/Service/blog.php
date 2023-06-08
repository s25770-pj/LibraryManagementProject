<?php

require_once '../Config/config.php';
require_once '../Repository/article_repo.php';

if (!isset($_SESSION['logged'])){
    header("Location: $login");
    die;
}

$db = new Database('localhost', 'root', '', 'blog');
$articleRepository = new ArticleRepository($db);

?>

<a href = "<?php echo $logout?>">logout</a>
<a href = "<?php echo $create_article?>">Create article</a>
<a href = "<?php echo $my_articles?>">My articles</a>

<?php
$articles = $articleRepository->get_all_articles();
foreach ($articles as $article) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php echo $style ?>
    <title>Blog</title>
</head>
<body>

<li>
<span class="article_author"><?php echo $article['author_name'] ?></span> 
<span class="article_title"><?php echo $article['title'] ?></span>
<span class="article_content"><?php echo $article['content'] ?></span>
<span class="article_last_update"><?php echo $article['updated_at'] ?></span>
</li>
<?php 
}
?>
    
</body>
</html>