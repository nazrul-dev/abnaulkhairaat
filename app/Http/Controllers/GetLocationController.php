<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetLocationController extends Controller
{
    public function __invoke(Request $request)
    {

        try {
            $data = \Indonesia::search($request->query('search'))->paginateDistricts();
            $results = $data->toArray();
            return response()->json($results['data']);
        } catch (\Throwable $th) {
            return response()->json();
        }
    }
}
