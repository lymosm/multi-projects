<?php
/**
 * RESTAPI DEMO
 * visit: http:host/api/visits/1 
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;

class VisitsController extends Controller
{
    //

    public function index(){
        return Visit::all();
    }

    public function show(Visit $visit){
        return $visit;
    }

    public function store(Request $request){
        $ip = $request->ip();
        $user_agent = $request->userAgent();
        // $params = $request->all();

        $visit = Visit::create([
            'ip' => $ip,
            'user_agent' => $user_agent
        ]);
        return response()->json(['status' => true], 201); // 201 created
    }

    public function update(Request $request, Visit $visit){
        $visit->update($request->all());
        return response()->json($visit, 200);
    }

    public function destroy(Visit $visit){
        $visit->delete();
        return response()->json(null, 204);  // no content
    }
}
