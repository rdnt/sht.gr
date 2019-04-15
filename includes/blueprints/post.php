<?php

// $location = explode('/', $core->getCurrentPage());
//
// if (!isset($location[2])) {
//     $core->redirect("/blog");
// }
// $slug = $location[2];
// $post = $core->getPostFromSlug($slug);
//
// if (!$post) {
//     $this->serveErrorPage(404, $location);
// }



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
