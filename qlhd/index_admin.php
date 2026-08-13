    <?php
    require_once __DIR__.'/app/Controller/AdminController.php';
    require_once __DIR__.'/app/Controller/OrderController.php';
    $db = (new Database())->getConnection();

    $admin = new AdminController();
    $order = new OrderController();

    $page = $_GET['page'] ?? 'home';
    $id = $_GET['id'] ?? 0;

    switch($page){
        case 'product': $admin->productsPage(); break;
        case 'addProduct': $admin->addProduct(); break;
        case 'updateProduct': $admin->updateProduct($id); break;
        case 'deleteProduct': $admin->deleteProduct($id); break;
        case 'order_list':
            $order->order_list($sort = 'newest',$status = 'null');
            break;
        case 'order_detail':
            $order->detail($id);
            break;
        case 'order_edit_form':
            $order->editForm($id);
            break;
        case 'order_update':
            $order->update($id, $_POST);
            break;
        case 'order_delete':
            $order->delete($id);
            break;
        default: $admin->index(); break;
    }
