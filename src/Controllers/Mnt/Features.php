<?php

namespace Controllers\Mnt;

use Controllers\PrivateController;

class Features extends PrivateController{
    public function run():void
    {
        $viewData = array();
        $viewData["Funciones"] = \Dao\Mnt\Features::getFeatures();
        $viewData["CanInsert"] = self::isFeatureAutorized("Controllers\Mnt\Feature\New");
        $viewData["CanUpdate"] = self::isFeatureAutorized("Controllers\Mnt\Feature\Upd");
        $viewData["CanDelete"] = self::isFeatureAutorized("Controllers\Mnt\Feature\Del");
        $viewData["CanView"] = self::isFeatureAutorized("Controllers\Mnt\Feature\Dsp");

        \Views\Renderer::render("mnt/features", $viewData);
    }
}



?>
