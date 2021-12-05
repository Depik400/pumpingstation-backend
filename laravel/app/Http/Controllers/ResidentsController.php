<?php

namespace App\Http\Controllers;

use App\Models\Periods;
use App\Models\Residents;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Residents::all();
    }

    public function getResindentOfStation(){
        return Residents::where('pumping_id',auth('api')->user()->id)->get();
    }

    public function updateResident(): \Illuminate\Http\JsonResponse
    {
        $id = \request()->post('id');
        $fio = \request()->post('fio');
        $area = \request()->post('area');
        $date = date_create_from_format('Y-m-j',\request()->post('date'))->format('Y-m-d');
        $time = date(' H:i:s',time());
        $date = $date.$time;
        DB::table('residents')->where('id',$id)->update(['fio' => $fio, 'area' => $area, 'start_date'=>$date]);
        return response()->json(['status'=>201]);
    }

    public function addNewResident(): \Illuminate\Http\JsonResponse {
        $pumping_id = auth('api')->user()->id;
        Residents::create([
            'fio' => \request()->post('fio'),
            'area' => \request()->post('area'),
            'pumping_id' => $pumping_id
        ]);
        Periods::createPeriod(null);

        return response()->json(['status' => 201]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Residents  $residents
     * @return \Illuminate\Http\Response
     */
    public function show(Residents $residents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Residents  $residents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Residents $residents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Residents  $residents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Residents $residents)
    {
        //
    }
}
