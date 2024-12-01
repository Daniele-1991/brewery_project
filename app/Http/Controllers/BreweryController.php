<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BreweryController extends Controller
{
    public function index(Request $request) 
    { 
        try { $response = Http::withOptions(['verify' => 'C:\certs\cacert.pem']
            ) ->get('https://api.openbrewerydb.org/breweries', 
            [ 'page' => $request->query('page', 1), 'per_page' => 10 ]); 
            if ($response->failed()) { Log::error('Error fetching breweries',
                 ['response' => $response->body()]); } 
                 return response()->json($response->json(), $response->status()); }
                  catch (\Exception $e) { Log::error('Exception fetching breweries',
                     ['message' => $e->getMessage()]);
         return response()->json(['error' => 'Internal Server Error'], 500); } }
}