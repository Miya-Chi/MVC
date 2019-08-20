<?php
require_once '../../config.php';

$controller = new GoodsController();
$controller->renderListPage();
$controller->paging();