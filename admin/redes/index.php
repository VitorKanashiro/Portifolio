<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/RedeController.php';
(new RedeController($conn))->listar();
