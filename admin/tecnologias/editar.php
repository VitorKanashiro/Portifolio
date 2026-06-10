<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/TecnologiaController.php';
(new TecnologiaController($conn))->editar();
