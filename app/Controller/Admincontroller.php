<?php
require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/Products.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Category.php';

class AdminController {
    private $sp;
    private $category;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->sp = new Product($db);
        $this->category = new Category($db);
    }

    public function index() {
        $productCountByCategory = $this->sp->getProductCountByCategory();
        $topSellingProducts = $this->sp->getTopSellingProducts(6);
        include __DIR__ . '/../View/View_admin/home.php';
    }

    public function productsPage() {
        $products = $this->sp->getAllProducts();
        include __DIR__ . '/../View/View_admin/products.php';
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinh = '';
            if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
                $hinh = time() . '_' . basename($_FILES['hinh_anh']['name']);
                move_uploaded_file($_FILES['hinh_anh']['tmp_name'], __DIR__ . '/../../public/Shop/img/' . $hinh);
            }
            $this->sp->addProduct([
                'ten_san_pham' => $_POST['ten_san_pham'],
                'danh_muc_id'  => $_POST['danh_muc_id'],
                'mo_ta'        => $_POST['mo_ta'],
                'hinh_anh'     => $hinh,
            ]);
            header("Location: index_admin.php?page=product");
            exit;
        }
        include __DIR__ . '/../View/View_admin/products_add.php';
    }

    public function updateProduct($id) {
        $product = $this->sp->getProductById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinh = $product['hinh_anh'];
            if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
                $hinh = time() . '_' . basename($_FILES['hinh_anh']['name']);
                move_uploaded_file($_FILES['hinh_anh']['tmp_name'], __DIR__ . '/../../public/Shop/img/' . $hinh);
            }
            $this->sp->updateProduct($id, [
                'ten_san_pham' => $_POST['ten_san_pham'],
                'danh_muc_id'  => $_POST['danh_muc_id'],
                'mo_ta'        => $_POST['mo_ta'],
                'hinh_anh'     => $hinh,
            ]);
            header("Location: index_admin.php?page=product");
            exit;
        }
        include __DIR__ . '/../View/View_admin/products_edit.php';
    }

    public function deleteProduct($id) {
        $this->sp->deleteProduct($id);
        header("Location: index_admin.php?page=product");
        exit;
    }

    public function usersPage() {
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'khach_hang';

            if ($name === '' || $email === '' || $password === '') {
                $_SESSION['info'] = 'Vui lòng nhập đầy đủ thông tin.';
            } elseif ($userModel->checkEmail($email)) {
                $_SESSION['info'] = 'Email này đã tồn tại.';
            } else {
                $userModel->register($name, $email, $password, $phone, $role);
                $_SESSION['info'] = 'Thêm người dùng thành công.';
            }

            header('Location: index_admin.php?page=users');
            exit;
        }

        $users = $userModel->getAllUsers();
        include __DIR__ . '/../View/View_admin/users.php';
    }

    public function categoriesPage() {
        $dsdm = $this->category->getAllCategories();
        $dm_edit = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cat'])) {
            $name = trim($_POST['catname'] ?? '');
            $editId = isset($_POST['idedit']) ? (int)$_POST['idedit'] : 0;

            if ($name !== '') {
                if ($editId > 0) {
                    $this->category->updateCategory($editId, $name);
                } else {
                    $this->category->addCategory($name);
                }
            }

            header('Location: index_admin.php?page=category');
            exit;
        }

        if (isset($_GET['idedit'])) {
            $dm_edit = $this->category->getCategoryById((int)$_GET['idedit']);
        }

        include __DIR__ . '/../View/View_admin/category.php';
    }

    public function deleteCategory($id) {
        if ($id > 0) {
            $this->category->deleteCategory($id);
        }
        header('Location: index_admin.php?page=category');
        exit;
    }
}
