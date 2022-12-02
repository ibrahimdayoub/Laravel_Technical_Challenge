<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subunit;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function setUnit(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'unit_name'=>['required','string','max:100','unique:units'],
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $unit=new Unit;
            $unit->unit_name=$request->input('unit_name');
            $unit->save();
            return response()->json([
                'message'=>'Unit Added Successfully',
            ]);
        }
    }

    // if you need..
    /*
        public function getUnits()
        {
            $units=Unit::all();

            return response()->json([
                'units'=>$units
            ]);
        }
        //
        public function getUnit($id)
        {
            $unit=Unit::find($id);

            if($unit)
            {
                return response()->json([
                    'unit'=>$unit
                ]);
            }
            else
            {
                return response()->json([
                    'message'=>'Unit Is Not Found',
                ]);
            }
        }
        //
        public function updateUnit(Request $request,$id)
        {
            $validator=Validator::make($request->all(),[
                'unit_name'=>['required','string','max:100','unique:units'],
            ]);

            if($validator->fails())
            {
                return response()->json([
                    'validation_errors'=>$validator->messages(),
                ]);
            }
            else
            {
                $unit=Unit::find($id);
                if($unit)
                {
                    $unit->unit_name=$request->input('unit_name');
                    $unit->save();
                    return response()->json([
                        'message'=>'Unit Updated Successfully',
                    ]);
                }
                else
                {
                    return response()->json([
                        'message'=>'Unit Is Not Found',
                    ]);
                }
            }
        }
        //
        public function removeUnit($id)
        {
            $unit=Unit::find($id);

            if($unit)
            {

                // There Is Relation Between Two Models And When I Delete |Unit|
                // I Will Delete All |Subunits| That Related With This Unit.. Etc.


                $subunits=Subunit::where('unit_id','=',$id)->get();
                if(count($subunits)>0)
                {
                    for($j=0; $j < count($subunits); $j++)
                    {
                        $subunits[$j]->delete();
                    }
                }


                // There Is Relation Between Two Models And When I Delete |Unit|
                // I Will Delete All |Products| That Related With This Unit.. Etc.


                $products=Product::where('unit_id','=',$id)->get();
                if(count($products)>0)
                {
                    for($j=0; $j < count($products); $j++)
                    {
                        $products[$j]->delete();
                    }
                }

                $unit->delete();
                return response()->json([
                    'message'=>'Unit Deleted Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'message'=>'Unit Is Not Found',
                ]);
            }
        }
        //
        public static function getUnitSubunits($id) //get subunits for unit
        {
            $unit=Unit::find($id);

            if($unit)
            {
                $subunits=Unit::find($id)->subunits;

                if(count($subunits)>0)
                {
                    return response()->json([
                        'subunits'=>$subunits
                    ]);
                }
                else if(count($subunits)==0)
                {
                    return response()->json([
                        'message'=>'Subunits are Not Found',
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'message'=>'Unit Is Not Found',
                ]);
            }
        }
    */
}
