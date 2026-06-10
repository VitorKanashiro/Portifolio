<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/MensagemController.php';
(new MensagemController($conn))->excluir();
