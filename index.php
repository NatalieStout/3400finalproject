<?php
require 'config.php';

session_start();

// Connect to MySQL
$pdo = pdo_connect_mysql();

$msg = "";
$err = false;

if (isset($_GET['msg'], $_GET['err'])) {
    $msg = $_GET['msg'];
    $err = $_GET['err'];
}

// Query that selects all the polls from the database
$stmt = $pdo->query('SELECT * FROM blog_post');
$blog_post = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Polls') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <?php if ($msg && !$err) : ?>
            <div class="notification is-success is-light py-2">
                <p><strong><?php echo $msg; ?></strong></p>
            </div>
        <?php elseif ($msg && $err) : ?>
            <div class="notification is-danger is-light py-2">
                <p><strong><?php echo $msg; ?></strong></p>
            </div>
        <?php endif; ?>

        <h1 class="title">Welcome to the Blog!</h1>
        <p>View our most recent blog entries below.</p>

        <div class="container">

        <?php foreach ($blog_post as $post): ?>
        <div class="card m-5 p-5" style="width: 100%;">
            <div class="row no-gutters">
                <div class="card-body">
                    <h2 class="card-title"><strong><?= $post['title'] ?></strong></h2>
                    <h5 class="card-title"><small class="text-muted">By <?= $post['author_name'] ?></small></h5>
                    
                </div>

                <div class="content article-body">
                <p><?= substr($post['content'], 0, 100) ?>...
                <span class=""><a href="blog-post.php?id= <?=$post['id']?>">Learn More.</a></span>
                </p>
                </div>
                
            </div>
            </div>
            <?php endforeach; ?>


    <!-- END PAGE CONTENT -->

<?= template_footer() ?>