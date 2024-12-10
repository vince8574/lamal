<?php

namespace App\ViewModels;

use App\Models\AgeRange;
use App\Models\Canton;
use App\Models\Insurer;
use App\Models\Tariftype;
use KDA\Laravel\Viewmodel\ViewModel;

class FiltersValuesViewModel extends ViewModel
{
    //

    public function __construct() {}

    public function getAges()
    {
        return AgeRange::orderBy('key')->get();
    }

    public function getCantons()
    {
        return Canton::orderBy('name')->get();
    }

    public function getInsurers()
    {
        return Insurer::orderBy('name')->get();
    }

    public function getTariftypes()
    {
        return Tariftype::orderBy('label')->get();
    }
}
