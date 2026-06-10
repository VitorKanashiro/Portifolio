<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/ContatoController.php';
(new ContatoController($conn))->editar();
