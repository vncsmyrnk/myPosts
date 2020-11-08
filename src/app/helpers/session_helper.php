<?php

session_start();

function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {

        // Caso seja passado o atributo messages e a mensagem não foi incluída na session. A mensagem é armazenada.
        if (!empty($message) && empty($_SESSION[$name])) {
            // Acho que esses unsets são inuteis
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
    
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } else if (empty($message) && !empty($_SESSION[$name])) {
            // Caso não seja passado o atributo messages e a mensagem já foi incluída na session. Apenas mostra a mensagem
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }

    }
    
}