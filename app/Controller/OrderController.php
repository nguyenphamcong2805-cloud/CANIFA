<?php
require_once __DIR__ . '/../Model/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function orderList() {
        $sort   = $_GET['sort'] ?? 'newest';
        $status = $_GET['status'] ?? null;

        $orders = $this->orderModel->getAll($sort, $status);
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

    public function update($id = null, $data = []) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = !empty($id) ? intval($id) : intval($_POST['id'] ?? 0);
            $trang_thai = $data['trang_thai_thanh_toan'] ?? $_POST['trang_thai_thanh_toan'] ?? '';
            if ($id > 0 && $trang_thai !== '') {
                $this->orderModel->updateStatus($id, $trang_thai);
            }
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


