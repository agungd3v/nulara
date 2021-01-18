<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\People;
use Exception;

class PeopleController extends Controller
{
    public function getPeople() {
        return response()->json([
            'status' => true,
            'data' => People::all()
        ]);
    }

    public function firstPeople($id) {
        return response()->json([
            'status' => true,
            'data' => People::where('id', $id)->first()
        ]);
    }

    public function storePeople(Request $request) {
        try {
            $people = new People();
            $people->first_name = $request->firstName;
            $people->last_name = $request->lastName;
            $people->age = $request->age;
            $people->gender = $request->gender;
            $people->hoby = $request->hoby;
            $people->save();

            return response()->json([
                'status' => true,
                'message' => 'People Saved'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ]);
        }
    }

    public function updatePeople(Request $request, $id) {
        try {
            $people = People::where('id', $id)->first();
            if (!$people) {
                return response()->json([
                    'status' => false,
                    'message' => 'Orang tidak terdefinisi'
                ]);
            }
            $people->first_name = $request->first_name;
            $people->last_name = $request->last_name;
            $people->age = $request->age;
            $people->gender = $request->gender;
            $people->hoby = $request->hoby;
            $people->save();

            return response()->json([
                'status' => true,
                'message' => 'People Updated'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ]);
        }
    }

    public function deletePeople($id) {
        try {
            $people = People::where('id', $id)->first();
            if (!$people) {
                return response()->json([
                    'status' => false,
                    'message' => 'Orang tidak terdefinisi'
                ]);
            }
            $people->delete();
            return response()->json([
                'status' => true,
                'message' => 'People Deleted'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ]);
        }
    }
}
