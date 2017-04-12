<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function testData()
    {
        $sample = [
            "userId" => 1,
            "id" => 1,
            "title" => "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            "body" => "quia et suscipit suscipit recusandae consequuntur expedita et cum reprehenderit molestiae ut ut quas totam nostrum rerum est autem sunt rem eveniet architecto"
        ];

        return response()->json($sample);
    }
}
