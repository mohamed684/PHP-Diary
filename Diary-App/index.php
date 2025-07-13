<?php
require __DIR__ . '/inc/functions.php';
require __DIR__ . '/inc/db-connect.php';

date_default_timezone_set('Africa/Cairo');

$perPage = 2;
$page = (int) ($_GET['page']?? 1);
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare('SELECT * FROM entries ORDER BY `date` DESC, `id` DESC LIMIT :perPage OFFSET :offset');
$stmt->bindValue('perPage', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCount = $pdo->prepare('SELECT COUNT(*) AS `count` FROM entries');
$stmtCount->execute();
$count = $stmtCount->fetch(PDO::FETCH_ASSOC)['count'];

$numPages = ceil($count / $perPage);


?>

<?php require __DIR__ . '/views/header.php'; ?>


<h1 class="main-heading">Entries</h1>

<?php foreach($results as $result): ?>

    <div class="card">
        <?php if($result['image']): ?>
            <div class="card-image-container">
                <img src="uploads/<?= e($result['image']) ?>" alt="Entry 1" class="card-image">
            </div>
        <?php endif ?>
        <div class="card-desc-container">
            <div class="card-desc-time">
                <?php 
                    $dateExploded = explode('-', $result['date']);
                    $timeStamp = mktime(12, 0, 0, $dateExploded[1], $dateExploded[2], $dateExploded[0]);
                    $date = date('d/m/Y', $timeStamp);
                ?>
                <?= e($date) ?>
            </div>
            <h2 class="card-desc-heading">
                <?= e($result['title']) ?>
            </h2>
            <p class="card-desc-text">
                <?= nl2br(e($result['message'])) ?>
            </p>
        </div>
    </div>

<?php endforeach ?>

<!-- Pagination -->
<?php if($numPages > 1): ?>
    <ul class="pagination">
        <?php if($page > 1): ?>
            <li class="pagination-item">
                <a href="index.php?<?php echo http_build_query(['page' => $page - 1]); ?>" class="pagination-link">&laquo;</a>
            </li>
        <?php endif ?>

        <?php for($i = 1; $i <= $numPages; $i++): ?>
            <li class="pagination-item">
                <a href="index.php?<?php echo http_build_query(['page' => $i]); ?>" class="pagination-link <?php if($i === $page): ?>active<?php endif ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor ?>

        <?php if($page < $numPages): ?>
            <li class="pagination-item">
                <a href="index.php?<?php echo http_build_query(['page' => $page + 1]); ?>" class="pagination-link">&raquo;</a>
            </li>
        <?php endif ?>
    </ul>
<?php endif ?>


<?php require __DIR__ . '/views/footer.php'; ?>
