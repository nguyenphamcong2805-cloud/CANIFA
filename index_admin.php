    <?php
    session_start();

    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
        header('Location: index_shop.php?ctrl=home&act=login');
        exit;
    }

    if (!defined('BASE_URL_SITE')) {
        define('BASE_URL_SITE', 'http://localhost/CANIFA/');
    }
    if (!defined('BASE_URL')) {
        define('BASE_URL', 'http://localhost/CANIFA/public/Shop/');
    }

    require_once __DIR__.'/app/Controller/Admincontroller.php';
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
        case 'users': $admin->usersPage(); break;
        case 'category': $admin->categoriesPage(); break;
        case 'category_delete': $admin->deleteCategory((int)$id); break;
        case 'order_list':
            $order->orderList();
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
