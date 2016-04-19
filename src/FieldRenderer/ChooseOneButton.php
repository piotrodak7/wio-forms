<?php
namespace WioForms\FieldRenderer;

class ChooseOneButton extends AbstractFieldRenderer
{

    function showToEdit(){
        $value = '';
        if ( !empty($this->fieldInfo['value']) )
        {
            $value = $this->fieldInfo['value'];
        }

        $styleOptions = [];
        if ( isset($this->fieldInfo['styleOptions']) )
        {
            $styleOptions = $this->fieldInfo['styleOptions'];
        }

        $message = false;
        if( isset($this->fieldInfo['valid']) and !$this->fieldInfo['valid'] )
        {
            $message = $this->fieldInfo['message'];
        }
        if ( isset($styleOptions['dont_display_errors']) and $styleOptions['dont_display_errors'] )
        {
            $message = false;
        }

        $dataSet = [];
        $dataSetName = $this->fieldInfo['dataSet']['repositoryName'];
        if ( isset( $this->formStruct['DataRepositories'][$dataSetName] ) )
        {
            $dataSet = &$this->formStruct['DataRepositories'][$dataSetName]['data'];
        }
        else
        {
            $this->wioForms->errorLog->errorLog('DataRepository: '.$dataSetName.' not found.');
        }

        $html = '';
        $html .= $this->fieldInfo['title'].': ';


        foreach ( $dataSet as $option => $option_name)
        {
            $selected = '';
            if ($option == $value)
            {
                $selected = ' selected="selected"';
            }
            $html .= '<button type="submit" name="'.$this->fieldName.'" value="'.$option.'">'.$option_name.'</button>';
        }
        if ($message !== false)
        {
            $html .= '<b style="color: red;"> &nbsp; '.$message.'</b>';
        }
        $html .= '<br/>';


        return $html;
    }

    function showToView(){
        $html = 'TextInput: '.'abc'.'<br/>';

        return $html;
    }
}

?>
