<?php

require_once __DIR__ . '/../model/PaymentModel.php';

    class PaymentController {
        private $paymentModel;

        public function __construct($conn) {
            $this->paymentModel = new PaymentModel($conn);
        }

        
        public function checkout($user_id, $cart) {
            
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['amount'];
            }

            
            $orderData = [
                'user_id' => $user_id,  
                'total' => $total,
                'cart' => $cart        
            ];

            $order_id = $this->paymentModel->createOrder($orderData);

            return ['order_id' => $order_id, 'total' => $total];
        }
    }
?>
