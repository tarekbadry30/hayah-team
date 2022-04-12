<?php

namespace App\Http\Controllers\API\DonationType;

use App\Http\Controllers\Controller;
use App\Http\Resources\DonationTypeResource;
use App\Models\DonationType;
use Illuminate\Http\Request;

class DonationTypeController extends Controller
{
    public function index()
    {
        $types=DonationType::where('status','enabled')->get();
        //$category=Category::whereNull('parent_id')->get();
        return DonationTypeResource::collection($types);
    }
}
