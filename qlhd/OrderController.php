<?php
require_once __DIR__ . '/../Model/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function list() {
        $orders = $this->orderModel->getAll();
           require __DIR__ . '/../View/View_admin/header.php';
        include __DIR__ . '/../View/View_admin/order_list.php';
    }

    public function detail($id){
        $order = $this->orderModel->getById($id);
        if (!$order) {
            die('Đơn hàng không tồn tại');
        }
        $items = $this->orderModel->getOrderItems($id);
           require __DIR__ . '/../View/View_admin/header.php';
        include __DIR__.'/../View/View_admin/order_detail.php';
    }

    public function editForm($id){
        $order = $this->orderModel->getById($id);
        if (!$order) {
            die('Đơn hàng không tồn tại');
        }
        require __DIR__ . '/../View/View_admin/header.php';
        include __DIR__.'/../View/View_admin/order_edit.php';
    }

    public function update(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $trang_thai = $_POST['trang_thai_thanh_toan'];
            $this->orderModel->updateStatus($id, $trang_thai);
            require __DIR__ . '/../View/View_admin/header.php';
            header('Location: index_admin.php?page=order_list');
            exit;
        }
    }

    public function delete($id){
        $this->orderModel->delete($id);
        header('Location: index_admin.php?page=order_list');
        exit;
    }

    }


