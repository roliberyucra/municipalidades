<?php
session_start();

require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/app/controllers/MunicipioController.php";
require_once __DIR__ . "/app/controllers/ClienteController.php";
require_once __DIR__ . "/app/controllers/AuthController.php";
require_once __DIR__ . "/app/controllers/TokenController.php"; // ✅ nuevo controlador

if (!isset($pdo)) {
    die("Error: No se pudo establecer conexión a la base de datos.");
}


$municipioController = new MunicipioController($pdo);
$clienteController   = new ClienteController($pdo);
$authController      = new AuthController($pdo);
$tokenController     = new TokenController($pdo); // ✅ instancia

$action = $_GET['action'] ?? 'index';

switch ($action) {
    /* --- Municipios --- */
    case 'index':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        $municipioController->index();
        break;

    case 'createForm':
        $municipioController->createForm();
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $municipioController->store($_POST);
        }
        break;

    /* --- Clientes API --- */
    case 'clientes':
    case 'viewClient':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        $clienteController->index();
        break;

    case 'clienteCreateForm':
        $clienteController->createForm();
        break;

    case 'clienteStore':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clienteController->store($_POST);
        }
        break;

    /* --- Tokens --- */
    case 'tokens': // lista de tokens
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        $tokenController->index();
        break;

    case 'createTokenForm': // formulario para generar
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        $tokenController->createForm();
        break;

    case 'storeToken': // guardar token generado
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=loginForm");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tokenController->store($_POST);
        }
        break;

    /* --- Autenticación --- */
    /* --- Autenticación --- */
case 'loginForm':
    $authController->loginForm();
    break;

case 'login':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->login($_POST);
    } else {
        header("Location: index.php?action=loginForm");
    }
    break;

case 'registerForm':
    $authController->registerForm();
    break;

case 'register':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->register($_POST);
    } else {
        header("Location: index.php?action=registerForm");
    }
    break;

case 'logout':
    $authController->logout();
    break;

    default:
        echo "Acción no válida.";
}
