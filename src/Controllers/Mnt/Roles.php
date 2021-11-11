<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Roles extends PublicController{
    public function run(): void
    {
        $viewData = array();
        $viewData["items"] = \Dao\Mnt\Roles::getRoles();
        $viewData["new_enabled"] = true;
        $viewData["edit_enabled"] = true;
        $viewData["delete_enabled"] = true;
        Renderer::render("mnt/roles", $viewData);
    }
}
?>