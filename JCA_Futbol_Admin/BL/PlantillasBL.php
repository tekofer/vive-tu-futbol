<?php

/**
 * Controla la generacion de Plantillas
 * @author Diego Saavedra
 * @created 04/01/2017
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once '../Utiles/Classes/PHPExcel/IOFactory.php';
    require_once '../Utiles/Classes/PHPExcel.php';
    require_once('../DA/PlantillasDA.php');
    $db = new PlantillasDA();

    switch ($action) {
        case 'generarPlantilla' :

            $idCampeonato = $_POST['idCampeonato'];
            $idEquipo1 = $_POST['idEquipo1'];
            $idEquipo2 = $_POST['idEquipo2'];
            $campeonato = $_POST['campeonato'];
            $equipo1 = $_POST['equipo1'];
            $equipo2 = $_POST['equipo2'];

            $ruta = "../Utiles/PlanillaFutbol5.xlsx";
            $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
            $plantilla = $plantilla->load($ruta); // Empty Sheet
            $plantilla->setActiveSheetIndex(0);

            $jugadores = $db->obtenerJugadores($idCampeonato, $idEquipo1, $idEquipo2);
            $arrayJugadores = array();
            $indicadorCeldaEquipo1 = 16;

            $plantilla->getActiveSheet()->setCellValue('K6', $equipo1)
                    ->setCellValue('BA6', $equipo2)
                    ->setCellValue('B7', 'CAMPEONATO.  ' . $campeonato);

            for ($i = 0; $i < count($jugadores); $i++) {
                if ($jugadores[$i]['Equipo'] == $equipo1) {
                    $plantilla->getActiveSheet()->setCellValue('B' . $indicadorCeldaEquipo1, $jugadores[$i]['Cedula'])
                            ->setCellValue('G' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                    ++$indicadorCeldaEquipo1;
                }
            }

            $indicadorCeldaEquipo2 = 41;

            for ($i = 0; $i < count($jugadores); $i++) {
                if ($jugadores[$i]['Equipo'] == $equipo2) {
                    $plantilla->getActiveSheet()->setCellValue('B' . $indicadorCeldaEquipo2, $jugadores[$i]['Cedula'])
                            ->setCellValue('G' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                    ++$indicadorCeldaEquipo2;
                }
            }
            $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
            $objWriter->save('../Utiles/PlanillaFutbol5_Generada.xlsx');
            echo '{"error": "2", "url": "http://127.0.0.1:8080/vive-tu-futbol/JCA_Futbol_Admin/Utiles/PlanillaFutbol5_Generada.xlsx"}';
            break;
    }
}