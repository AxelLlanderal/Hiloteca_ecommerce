<?php
/*
| CONTROLADOR AUTENTICACIÓN
*/

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    /*
    | MOSTRAR LOGIN
    */
    public function mostrarLogin() {
        require __DIR__ . '/../views/login.php';
    }

    /*
    | MOSTRAR REGISTRO
    */
    public function mostrarRegistro() {
        require __DIR__ . '/../views/registro.php';
    }

    /*
    | REGISTRAR USUARIO
    */
    public function registrar() {
        session_start();

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($nombre) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Todos los campos son obligatorios";
            header("Location: index.php?accion=registro");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "El correo no es válido";
            header("Location: index.php?accion=registro");
            exit;
        }

        $registrado = Usuario::registrar($nombre, $email, $password);

        if (!$registrado) {
            $_SESSION['error'] = "Ese correo ya está registrado";
            header("Location: index.php?accion=registro");
            exit;
        }

        $_SESSION['mensaje'] = "Usuario registrado correctamente";
        header("Location: index.php?accion=login");
        exit;
    }

    /*
    | VALIDAR LOGIN
    */
    public function login() {
        session_start();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Correo y contraseña son obligatorios";
            header("Location: index.php?accion=login");
            exit;
        }

        $usuario = Usuario::login($email, $password);

        if ($usuario) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol']
            ];

            $_SESSION['usuario_id'] = $usuario['id'];

            if ($usuario['rol'] == 'admin') {
                header("Location: index.php?accion=admin_dashboard");
            } else {
                header("Location: index.php");
            }
            exit;
        }

        $_SESSION['error'] = "Correo o contraseña incorrectos";
        header("Location: index.php?accion=login");
        exit;
    }

    /*
    | CERRAR SESIÓN
    */
    public function logout() {
        session_start();
        session_destroy();

        header("Location: index.php?accion=login");
        exit;
    }
}
?>