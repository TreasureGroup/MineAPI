<?php

namespace mineapi\loader;

interface LoaderManager
{
    /**
     * @return void
     */
    public function onInit() : void;

    /**
     * @return string
     */
    public function getName() : string;
}
