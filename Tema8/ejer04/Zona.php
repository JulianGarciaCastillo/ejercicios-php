<?php

/**
 * Description of Zonas
 *
 * @author duveral
 */

class  Zona {                                                                                                                                            

// Atributos de instancia (o de objeto)
    private $tipo;
    private $numEntradas;

// Construct
    function __construct($tipo, $numEntradas) {
        $this->tipo = $tipo;
        $this->numEntradas = $numEntradas;
    }

// Getter and Setter   
    function getTipo() {
        return $this->tipo;
    }

    function getNumEntradas() {
        return $this->numEntradas;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setNumEntradas($numEntradas) {
        $this->numEntradas = $numEntradas;
    }

// Metodos de instancia (objeto)
    public function actionVende($cantidadEntradas) {
        $numEntradas = $this->getNumEntradas() - $cantidadEntradas;

            if ($numEntradas < 0){
                return false;
            }else{
        
                $this->setNumEntradas($numEntradas);
                return true;
            }       
    }

// To String
    public function __toString() {
        return " Tipo de Zona: " . $this->getTipo() . 
                   "<br>Entradas disponibles: " . $this->getNumEntradas();
    }


}
