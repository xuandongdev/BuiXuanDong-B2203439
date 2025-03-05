<?php
    require_once __DIR__ . '/../../connect.php';
    require_once __DIR__ . '/../../controller/MedicineController.php';

    header('Content-Type: application/json');

    $controller = new MedicineController($conn);

    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $query = trim($_GET['query']);
        $results = $controller->searchMedicine($query);
        echo json_encode($results);
    } else {
        echo json_encode([]);
    }
?>
