<?php

function getHousingAsStr($type) {
    switch ($type) {
        case 0:
            return '';
        case 1:
            return 'House';
        case 2:
            return 'Flat';
        case 3:
            return 'Villa';
        default:
            return '';
    }
}