<?php

/**
 * Controla la logica de Negocio de los Equipos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once('../DA/EquiposDA.php');
    $db = new EquiposDA();
    switch ($action) {
        case 'obtenerEquipos' :
            $equipos = $db->obtenerEquipos();
            $arrayEquipos = array();
            for ($i = 0; $i < count($equipos); $i++) {
                $arrayEquipos[$i]['IdEquipo'] = $equipos[$i]['IdEquipo'];
                $arrayEquipos[$i]['IdCampeonato'] = $equipos[$i]['IdCampeonato'];
                $arrayEquipos[$i]['Campeonato'] = $equipos[$i]['Campeonato'];
                $arrayEquipos[$i]['Nombre'] = $equipos[$i]['Nombre'];
                $arrayEquipos[$i]['Descripcion'] = $equipos[$i]['Descripcion'];
                $arrayEquipos[$i]['Puntos'] = $equipos[$i]['Puntos'];
                $arrayEquipos[$i]['Grupo'] = $equipos[$i]['Grupo'];
            }
            echo json_encode($arrayEquipos);
            break;
        case 'registrarEquipoGrupo':
            $equipo = $db->registrarEquipoCampeonato($_POST['idCampeonato'], $_POST['nombreEquipo'], $_POST['descripcionEquipo'], $_POST['idGrupo']);
            break;
        case 'autoCompletarEquipo':
            $Equipo = $_POST['term'];
            $IdCampeonato = $_POST['IdCampeonato'];
            $list = $db->autocompletarEquipo($Equipo, $IdCampeonato);
            echo json_encode($list);
            break;   
        case 'eliminarEquipo':
            $equipos = $db->eliminarEquipo($_POST['idEquipoEliminar']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente el Equipo"}';
            break;
        case 'actualizarEquipoGrupo':
            $equipos=$db->actualizarEquipo($_POST['idEquipo'], $_POST['nombreEquipo'], $_POST['descripcionEquipo'], $_POST['idGrupo']);
        break;
    }
}