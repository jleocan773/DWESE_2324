<?php

    /*
        #Perfiles
        1. Administrador
        2. Editor
        3. Registrado

        Para ello vamos a definir variables como globales

        Perfiles	 	Nuevo	Editar	Eliminar	 Mostrar	Buscar 	Ordenar 
        ADMINISTRADOR	 SI	    SI	    SI	            SI	    SI	     SI
        EDITOR	 	     SI	    SI	    NO	            SI	    SI	     SI 
        REGISTRADO	 	 NO	    NO	    NO	            SI	    SI 	     SI
    */

    $GLOBALS['clientes']['main'] = [1, 2, 3];
    $GLOBALS['clientes']['nuevo'] = [1, 2];
    $GLOBALS['clientes']['editar'] = [1, 2];
    $GLOBALS['clientes']['delete'] = [1];
    $GLOBALS['clientes']['mostrar'] = [1,2,3];
    $GLOBALS['clientes']['buscar'] = [1,2,3];
    $GLOBALS['clientes']['ordenar'] = [1,2,3];
    $GLOBALS['clientes']['exportar'] = [1];
    $GLOBALS['clientes']['importar'] = [1];

    $GLOBALS['cuentas']['main'] = [1, 2, 3];
    $GLOBALS['cuentas']['nuevo'] = [1, 2];
    $GLOBALS['cuentas']['editar'] = [1, 2];
    $GLOBALS['cuentas']['delete'] = [1];
    $GLOBALS['cuentas']['mostrar'] = [1,2,3];
    $GLOBALS['cuentas']['buscar'] = [1,2,3];
    $GLOBALS['cuentas']['ordenar'] = [1,2,3];
    $GLOBALS['cuentas']['exportar'] = [1];
    $GLOBALS['cuentas']['importar'] = [1];
