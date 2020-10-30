<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index() {
        $city=request()->get('city');
        return response()->json(Service::query()
            ->where('city',$city)
            ->with('types')->get(),
            200,[],JSON_UNESCAPED_UNICODE);
    }

    public function show(Service $services) {
        return response()->json(Service::query()->where('slug', $services), 200,[],JSON_UNESCAPED_UNICODE);
    }

}
