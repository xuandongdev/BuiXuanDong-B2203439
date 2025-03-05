<?php
    require_once __DIR__ . '/../model/MedicineModel.php'; 
    

    class MedicineController {
        private $model;
    
        public function __construct($conn) {
            $this->model = new MedicineModel($conn);
        }
    
        public function searchMedicine($query) {
            return $this->model->getMedicineSuggestions($query);
        }
    }
?>