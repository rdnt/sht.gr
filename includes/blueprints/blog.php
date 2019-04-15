<?php


// $location = explode('/', $core->getCurrentPage());
//
// if (!isset($location[3])) {
//     $core->redirect("/blog");
// }
// $currentPage = (int)$location[3];
// $postCount = $core->totalPosts();
// $totalPages = (int)($postCount / $core->totalPostsPerPage) + 1;
// if ($currentPage <= 1 || $currentPage > $totalPages) {
//     $core->redirect("/blog");
// }
//
// $core->blogPage = $currentPage;

$core->pages["/blog"]->current = true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $core->loadComponent("head") ?>
<title><?= $core->getTitle() ?></title>
</head>
<body>
<main>
<?php $core->loadComponent("nav") ?>
<?php $core->loadContent() ?>
</main>
<?php $core->loadComponent("footer") ?>
<?php $core->loadComponent("scripts") ?>
<?php $core->appendScripts() ?>
</body>
</html>
