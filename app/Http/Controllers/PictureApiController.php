<?php

namespace App\Http\Controllers;

use App\Pictures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PictureApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // fetch records from database
        $pictures = Pictures::take($request->limit && $request->limit <= 20 ? $request->limit : 10)
            ->orderBy('created_at', 'ASC')
            ->select([
                'title',
                'url',
                DB::raw("CONCAT ('" . url('/') . "/storage/' , path) AS local_url"),
                'description'
            ])
            ->get();

        return response()->json($pictures, 200);
    }
}
