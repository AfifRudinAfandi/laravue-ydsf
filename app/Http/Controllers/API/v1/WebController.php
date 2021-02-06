<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\HeroImage;

class WebController extends Controller
{
    public function getHeroImages()
    {
        $heroImages = HeroImage::orderBy('id', 'DESC')->limit(3)->get();
        return response()->json($heroImages);
    }
}
