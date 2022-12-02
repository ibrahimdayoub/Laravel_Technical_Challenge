<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\Subunit;
use Illuminate\Http\Request;

class SubunitController extends Controller
{
    public function setSubunit(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'subunit_name'=>['required','string','max:100','unique:subunits'],
            'unit_parts'=>['required','numeric'],
            'unit_id'=>['required','integer'],
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $subunit=new Subunit;
            $subunit->subunit_name=$request->input('subunit_name');
            $subunit->unit_parts=$request->input('unit_parts');
            $subunit->unit_id=$request->input('unit_id');
            $subunit->save();
            return response()->json([
                'message'=>'Subunit Added Successfully',
            ]);
        }
    }
    
    // if you need..
    /*
        public function getSubunits()
        {
            $subunits=Subunit::all();

            return response()->json([
                'subunits'=>$subunits
            ]);
        }
        //
        public function getSubunit($id)
        {
            $subunit=Subunit::find($id);

            if($subunit)
            {
                return response()->json([
                    'subunit'=>$subunit
                ]);
            }
            else
            {
                return response()->json([
                    'message'=>'Subunit Is Not Found',
                ]);
            }
        }
        //
        public function updateSubunit(Request $request,$id)
        {
            $validator=Validator::make($request->all(),[
                'subunit_name'=>['required','string','max:100','unique:subunits'],
                'unit_parts'=>['required','numeric'],
                'unit_id'=>['required','integer'],
            ]);

            if($validator->fails())
            {
                return response()->json([
                    'validation_errors'=>$validator->messages(),
                ]);
            }
            else
            {
                $subunit=Subunit::find($id);
                if($subunit)
                {
                    $subunit->subunit_name=$request->input('subunit_name');
                    $subunit->unit_parts=$request->input('unit_parts');
                    $subunit->unit_id=$request->input('unit_id');
                    $subunit->save();
                    return response()->json([
                        'message'=>'Subunit Updated Successfully',
                    ]);
                }
                else
                {
                    return response()->json([
                        'message'=>'Subunit Is Not Found',
                    ]);
                }
            }
        }
        //
        public function removeSubunit($id)
        {
            $subunit=Subunit::find($id);

            if($subunit)
            {
                $subunit->delete();
                return response()->json([
                    'message'=>'Subunit Deleted Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'message'=>'Subunit Is Not Found',
                ]);
            }
        }
        //
        public function getSubunitUnit($id) //get unit for subunit
        {
            $unit=Subunit::find($id)->unit;

            if($unit)
            {
                return response()->json([
                    'unit'=>$unit,
                ]);

            }
            else
            {
                return response()->json([
                    'message'=>'Subunit Is Not Found',
                ]);
            }
        }
    */
}
