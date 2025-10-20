<?php

require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/SubCategories.php';

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

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
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

    public function viewCategory($id)
    {
        if (!$id) {
            header('Location: index.php?action=categories');
            exit;
        }

        $category = $this->categoriesModel->getAllCategories();
        $subcategories = $this->categoriesModel->getAllSubCategoriesByCategory($id);
        $this->smarty->assign([
            'category_id' => $id,
            'subcategories' => $subcategories,
            'session' => $_SESSION
        ]);
        $this->smarty->display('category_view.tpl');
    }
}
