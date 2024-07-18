<?php

require 'config.php';

// Columnas a mostrar en la tabla
$columns = ['Id', 'Nombre', 'Apellidos', 'Escuela', 'Turno', 'Email', 'Password', 'password_plaintext'];

// Nombre de la tabla
$table = "usuarios";

// Campo a buscar
$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : '';

// Filtrado
$where = '1'; // Filtro inicial para evitar problemas de sintaxis SQL

if ($campo != '') {
    $where = "(";
    
    foreach ($columns as $column) {
        $where .= "$column LIKE '%$campo%' OR ";
    }
    $where = rtrim($where, " OR ") . ")";
}

// Limites
$limit = isset($_POST['registros']) ? intval($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;

$inicio = ($pagina - 1) * $limit;
$sLimit = "LIMIT $inicio, $limit";

// Ordenamiento
$sOrder = '';
$orderCol = isset($_POST['orderCol']) ? intval($_POST['orderCol']) : 0;
$orderType = isset($_POST['orderType']) && $_POST['orderType'] === 'desc' ? 'DESC' : 'ASC';

if (isset($columns[$orderCol])) {
    $sOrder = "ORDER BY {$columns[$orderCol]} $orderType";
}

// Consulta
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
        FROM $table
        WHERE $where
        $sOrder
        $sLimit";

$resultado = $conn->query($sql);
$num_rows = $resultado ? $resultado->num_rows : 0;

// Consulta para total de registros filtrados
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$totalFiltro = $resFiltro ? intval($resFiltro->fetch_array()[0]) : 0;

// Consulta para total de registros totales en la tabla
$sqlTotal = "SELECT COUNT(*) AS total FROM $table";
$resTotal = $conn->query($sqlTotal);
$totalRegistros = $resTotal ? intval($resTotal->fetch_array()['total']) : 0;

// Preparar el output JSON
$output = [
    'totalRegistros' => $totalRegistros,
    'totalFiltro' => $totalFiltro,
    'data' => '',
    'paginacion' => ''
];

// Generar HTML de los resultados
if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        foreach ($columns as $col) {
            $output['data'] .= '<td>' . htmlspecialchars($row[$col]) . '</td>'; // Evitar XSS usando htmlspecialchars
        }
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr><td colspan="8">Sin resultados</td></tr>';
}

// Generar HTML de la paginación
if ($totalRegistros > 0) {
    $totalPaginas = ceil($totalFiltro / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = max(1, $pagina - 4);
    $numeroFin = min($totalPaginas, $numeroInicio + 9);

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        $output['paginacion'] .= '<li class="page-item' . ($pagina == $i ? ' active' : '') . '">';
        $output['paginacion'] .= '<a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a>';
        $output['paginacion'] .= '</li>';
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

// Salida JSON
echo json_encode($output, JSON_UNESCAPED_UNICODE);
