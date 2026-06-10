<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/ProjetoController.php';
(new ProjetoController($conn))->excluir();
