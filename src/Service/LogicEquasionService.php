<?php
namespace WioForms\Service;

class LogicEquasionService
{
    private $wioForms;
    private $formStruct;

    function __construct( $wioFormsObiect )
    {
        $this->wioForms = $wioFormsObiect;
        $this->formStruct = &$this->wioForms->formStruct;
    }

    public function solveEquasion( $sentence )
    {
        $result = $this->solveSentence($sentence);
        return $result;
    }

    public function solveSentence($sentence)
    {

        if ( isset($sentence['data'] ) and is_array($sentence['data']) )
        {
            foreach ( $sentence['data'] as $i => $subSentence)
            {
                $sentence['data'][$i] = $this->solveSentence($subSentence);
            }
        }

        $result = true;
        switch( $sentence['type'] )
        {
            case 'fieldValue':
                $result = $this->getFieldValue($sentence);  break;
            case 'const':
                $result = $this->getConst($sentence);  break;
            case 'equal':
                $result = $this->getEqual($sentence);  break;
            case 'and':
                $result = $this->getAnd($sentence);  break;
            case 'or':
                $result = $this->getOr($sentence);  break;
            case 'isValidField':
                $result = $this->getIsValidField($sentence); break;
            case 'isNotValidField':
                $result = $this->getIsNotValidField($sentence); break;

            default:
                $this->wioForms->errorLog->errorLog('LogicEquasionError: No "'.$sentence['type'].'" sentence type.');
        }

        return $result;
    }

    private function getFieldValue($sentence)
    {
        $result = $this->formStruct['Fields'][ $sentence['field'] ]['value'];
        return $result;
    }

    private function getConst($sentence)
    {
        $result = $sentence['const'];
        return $result;
    }

    private function getEqual($sentence)
    {
        $result = true;
        for ($i = 1; $i < count($sentence['data']); ++$i)
        {
            if ($sentence['data'][$i] != $sentence['data'][ ($i-1) ])
            {
                $result = false;
                break;
            }
        }
        return $result;
    }

    private function getAnd($sentence)
    {
        $result = true;
        foreach ( $sentence['data'] as $element )
        {
            if ( !($element) )
            {
                $result = false;
                break;
            }
        }
        return $result;
    }

    private function getOr($sentence)
    {
        $result = false;
        foreach ( $sentence['data'] as $element )
        {
            if ( $element )
            {
                $result = true;
                break;
            }
        }
        return $result;
    }

    private function getIsNotValidField($sentence)
    {
        $result = false;
        if ( isset($this->formStruct['Fields'][ $sentence['field'] ]['valid'])
            and !$this->formStruct['Fields'][ $sentence['field'] ]['valid'] )
        {
            $result = true;
        }
        return $result;
    }

    private function getIsValidField($sentence)
    {
        $result = false;
        if ( isset($this->formStruct['Fields'][ $sentence['field'] ]['valid'])
            and $this->formStruct['Fields'][ $sentence['field'] ]['valid'] )
        {
            $result = true;
        }
        return $result;
    }


}

?>
