<?php
namespace WioForms\FieldValidator;

abstract class AbstractFieldValidator
{
    protected $wioForms;

    protected $valid;
    protected $state;
    protected $message;

    protected $validState = 1;
    protected $validMessage = '';
    protected $invalidState = -1;
    protected $invalidMessage = 'field_invalid';

    function __construct($wioFormsObject)
    {
        $this->wioForms = $wioFormsObject;

        $this->valid = false;
        $this->state = 0;
        $this->message = '';
    }


    abstract function validatePHP($value, $settings);


    protected function getReturn()
    {
        $array = [
            'valid'   => $this->valid,
            'state'   => $this->state,
            'message' => $this->message
        ];
        return $array;
    }

    protected function setAnswer()
    {
        if ($this->valid)
        {
            $this->state = $this->validState;
            $this->message = $this->validMessage;
        }
        else
        {
            $this->state = $this->invalidState;
            $this->message = $this->invalidMessage;
        }

    }

    public function print_validateJS()
    {
        $javascript = '';

        $javascript .= 'function( value, settings ){';
        $javascript .= 'return {valid:valid, state:state, message:message};';
        $javascript .= '}';

        return $javascript;
    }
}
