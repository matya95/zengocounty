<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountyResource;
use App\Models\City;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CountyResource::collection(County::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return County::with('hascities')->where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!empty($request->name)) {
            $county = County::find($request->countyid);
            $city = City::updateOrCreate(
                ['id' => $id],
                ['id' => $id, 'name' => $request->name]

            );
            $message = [
                'message' => 'You successfully updated the city name to ' . $request->name
            ];
            return response(json_encode($message));
        } else {
            $errors = [
                'message' => 'You have to add a city name'
            ];
            return response(json_encode($errors));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        City::destroy($id);
        $message = [
            'message' => 'You successfully deleted the city'
        ];
        return response(json_encode($message));
    }

    public function insertcity(Request $request)
    {
        if (!empty($request->name)) {
            $counyid = $request->id;
            $city = $request->name;
            $count = County::find($counyid);
            $cityy = new City();
            $cityy->name = $city;
            $count->hasCities()->save($cityy);
            $message = [
                'message' => 'You successfully created a city with the following name: ' . $city.' and id:'.$cityy->id
            ];
            return response(json_encode($message));

        } else {
            $errors = [
                'message' => 'You have to add a city name'
            ];
            return response(json_encode($errors));
        }
    }
}
