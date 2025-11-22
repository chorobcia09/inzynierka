<?php

require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/SubCategories.php';

/**
 * Klasa do obsługi kategorii
 */
class CategoryController
{
    private $smarty;
    private $categoriesModel;
    private $subCategoriesModel;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
        $db = new Database();
        $this->categoriesModel = new Categories($db);
        $this->subCategoriesModel = new SubCategories($db);
    }

    /**
     * Wyświetlenie kategorii
     */
    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $categories = $this->categoriesModel->getAllCategories();

        $this->smarty->assign([
            'category' => $categories,
            'session' => $_SESSION
        ]);
        $this->smarty->display('categories.tpl');
    }

    /**
     * wyświetlenie podkagorii
     */
    public function viewCategory($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user_id'] ?? 0;
        $family_id = (int)($_SESSION['family_id'] ?? 0);
        $category_id = $_GET['id'];
        $category_name = $this->categoriesModel->getAllCategoriesById($category_id);


        $subcategories = $this->subCategoriesModel->getAllSubCategories($id, $user_id, $family_id);
        $this->smarty->assign([
            'category_id' => $id,
            'family_id' => $family_id,
            'category_name' => $category_name[0]['name'],
            'subcategories' => $subcategories,
            'session' => $_SESSION
        ]);
        $this->smarty->display('category_view.tpl');
    }

    public function addSubCategory()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = (int)($_SESSION['user_id'] ?? 0);
        $family_id = $_SESSION['family_id'] ?? null;
        $category_id = 0;
        $name = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = (int)($_POST['category_id'] ?? 0);
            $name = trim($_POST['name'] ?? '');

            if ($category_id > 0 && !empty($name)) {
                $this->subCategoriesModel->addSubCategory($user_id, $family_id, $category_id, $name, 0);

                header('Location: index.php?action=viewCategory&id=' . $category_id);
                exit;
            }
        } else {
            $category_id = (int)($_GET['category_id'] ?? $_GET['id'] ?? 0);
        }

        if ($category_id <= 0) {
            header('Location: index.php?action=categories');
            exit;
        }

        $category_name = $this->categoriesModel->getAllCategoriesById($category_id);

        $this->smarty->assign([
            'category_id' => $category_id,
            'category_name' => $category_name[0]['name'],
            'session' => $_SESSION
        ]);
        $this->smarty->display('add_subcategory.tpl');
    }
}
