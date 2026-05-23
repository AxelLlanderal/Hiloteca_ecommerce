<?php
/*
| CONTROLADOR MENSAJES
*/

require_once __DIR__ . '/../models/MensajeContacto.php';

class MensajeController {

    /*
    | VALIDAR ADMIN
    */
    private function validarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
            header("Location: index.php?accion=login");
            exit;
        }
    }

    /*
    | FORMULARIO CONTACTO
    */
    public function contacto() {
        require __DIR__ . '/../views/contacto.php';
    }

    /*
    | GUARDAR MENSAJE
    */
    public function guardarMensaje() {
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $asunto = trim($_POST['asunto'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');

        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            header("Location: index.php?accion=contacto");
            exit;
        }

        MensajeContacto::guardar($nombre, $correo, $asunto, $mensaje);

        header("Location: index.php?accion=mensaje_enviado");
        exit;
    }

    /*
    | MENSAJE ENVIADO
    */
    public function mensajeEnviado() {
        require __DIR__ . '/../views/mensaje_enviado.php';
    }

    /*
    | MENSAJES ADMIN
    */
    public function adminMensajes() {
        $this->validarAdmin();

        $mensajes = MensajeContacto::obtenerTodos();

        require __DIR__ . '/../views/admin/mensajes.php';
    }

    /*
    | RESPONDER MENSAJE
    */
    public function responderMensaje($id) {
        $this->validarAdmin();

        $mensaje = MensajeContacto::obtenerPorId($id);

        require __DIR__ . '/../views/admin/responder_mensaje.php';
    }

    /*
    | GUARDAR RESPUESTA
    */
    public function guardarRespuesta() {
        $this->validarAdmin();

        $id = $_POST['id'] ?? null;
        $respuesta = trim($_POST['respuesta'] ?? '');

        MensajeContacto::responder($id, $respuesta);

        header("Location: index.php?accion=admin_mensajes");
        exit;
    }

    /*
    | MIS MENSAJES
    */
    public function misMensajes() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        $correo = $_SESSION['usuario']['email'];
        $mensajes = MensajeContacto::obtenerPorCorreo($correo);

        require __DIR__ . '/../views/mis_mensajes.php';
    }
}
?>