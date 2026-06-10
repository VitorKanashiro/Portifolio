<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/PerfilController.php';
(new PerfilController($conn))->editar();
