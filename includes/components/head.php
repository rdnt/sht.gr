<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
<link rel="manifest" href="/images/favicon/manifest.json">
<link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#0a0b0c">
<link rel="shortcut icon" href="/images/favicon/favicon.ico">
<meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
<meta name="theme-color" content="#0a0b0c">
<?php if ($sht->getCache() == 1): ?>
<link href="/css/materialize.min.css?v=<?=$sht->getVersion()?>" type="text/css" rel="stylesheet" media="screen"/>
<link href="/css/style.css?v=<?=$sht->getVersion()?>" type="text/css" rel="stylesheet" media="screen"/>
<?php else: ?>
<link href="/css/materialize.min.css?v=<?=$sht->getVersion()?>" rel="stylesheet" media="(max-height:0px)" onload="if(media!='all')media='all'"/>
<link href="/css/style.css?v=<?=$sht->getVersion()?>" rel="stylesheet" media="(max-height:0px)" onload="if(media!='all')media='all'"/>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/loader_styles.php"; ?>
<?php endif; ?>
