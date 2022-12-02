<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subunit;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();

        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->subunit_id) {
                $products[$i]->unit_name = Subunit::find($products[$i]->subunit_id)->subunit_name;
            } else {
                $products[$i]->unit_name = Unit::find($products[$i]->unit_id)->unit_name;
            }
        }
        return response()->json([
            'products' => $products
        ]);
    }

    public function setProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => ['required', 'string', 'max:100', 'unique:products'],
            'unit_id' => ['required', 'integer'], // for get subunits
            'subunit_id' => ['integer'], // for convert quantity from main unit to subunit if it has valid value
            'unit_arr' => ['required', 'array'],
            /*
                unit_arr has values (unit and subunits)
                ex: main unit is liter and subunits are deciliter, centiliter and milliliter
                1 liter = 10 deciliter = 100 centiliter = 1000 milliliter
                [1, 9, 7, 4] => = 1.974 liter
                [1, 0, 0, 4000] => 5 liter
                [1, 2, 0, 500] => 3.5 liter
                [0, 0, 1, 25] => 0.035 liter
            */
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {

            $data = $this->calcQuantity(
                $request->input('unit_arr'),
                $request->input('unit_id'),
                $request->input('subunit_id')
            );

            // $data = [$unit_name, $quantity]

            $product = new Product;
            $product->product_name = $request->input('product_name');
            $product->unit_id = $request->input('unit_id');
            $product->subunit_id = $request->input('subunit_id'); // can be null if i want main unit
            $product->quantity = $data[1]; // set quantity
            $product->save();
            $product->unit_name = $data[0];
            return response()->json([
                'message' => 'Product Added Successfully',
                'product' => $product
            ]);
        }
    }

    private function calcQuantity($arr, $unit_id, $subunit_id)
    {
        $input_arr = $arr; // ex => [1, 9, 7, 4]
        $subunits_values = [];
        $quantity = 0;
        $unit_name = "";

        $unit = Unit::find($unit_id);
        if ($unit) {
            $subunits = Unit::find($unit_id)->subunits;

            if (count($subunits) > 0) {
                for ($i = 0; $i < count($subunits); $i++) {
                    array_push($subunits_values, $subunits[$i]->unit_parts); // get subunits values
                }
            }
        }
        sort($subunits_values); // ex => [0.001, 0.01, 0.1]
        array_push($subunits_values, 1); // 1 is main unit
        $subunits_values = array_reverse($subunits_values); // ex: [1, 0.1, 0.01, 0.001]

        if (count($subunits_values) > count($input_arr)) {
            $dif = count($subunits_values) - count($input_arr);
            for ($i = 0; $i < $dif; $i++) {
                array_push($input_arr, 0);
            }
        } else if (count($input_arr) > count($subunits_values)) {
            $dif = count($input_arr) - count($subunits_values);
            for ($i = 0; $i < $dif; $i++) {
                array_push($subunits_values, 0);
            }
        }

        for ($i = 0; $i < count($subunits_values); $i++) {
            $quantity += $subunits_values[$i] * $input_arr[$i];
        }
        /*
            ex: [ 1, 0.1,  0.01, 0.001 ] * [1, 9, 7, 4] =>  $quantity = 1.974 liter
        */

        $unit_name = $unit->unit_name;

        // convert value of quantity from main unit to subunit if subunit_id has valid value
        $subunit = Subunit::find($subunit_id);
        if ($subunit) {
            $its_unit = Subunit::find($subunit_id)->unit;

            if ($its_unit) {
                if ($its_unit->unit_name == $unit->unit_name) {
                    $quantity *= 1 / $subunit->unit_parts;
                    $unit_name = $subunit->subunit_name;
                }
            }
        }

        return [$unit_name, $quantity];
    }
}
