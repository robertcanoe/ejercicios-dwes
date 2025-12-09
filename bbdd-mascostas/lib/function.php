<?php
    /**
     * 
     * @author Roberto Cano Estévez
     * @date  29/09/2025
    */

    // Función para limpiar datos de entrada
    function clearData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>