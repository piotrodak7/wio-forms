<?php

namespace WioForms\FormSaver;

abstract class AbstractFormSaver
{
    protected $wioForms;

    public function __construct($wioFormObject)
    {
        $this->wioForms = $wioFormObject;
    }

    abstract function makeSavingAction($settings);
}
