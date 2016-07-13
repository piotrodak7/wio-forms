<?php

namespace WioForms\FieldConverter;

class Stanowisko2Role extends AbstractFieldConverter
{
    public function convert($data)
    {
        $map = [
            'rada' => 'RW',
            'lider' => 'LR',
            'wolontariusz' => 'W'
            // LR_R - lider z propozycją rejonu
        ];

        if (isset($map[$data])) {
            return $map[$data];
        }

        return '';
    }
}
