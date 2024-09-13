<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Kit;
use App\Models\Shelf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class ValidateController extends Controller
{

    public function box(Request $request)
    {
        $id = Str::substr($request->data, 3);
        $box = Box::whereBox_id($id)->first();
        if ($box) {
            return response()->json([
                'id' => $box->box_id,
                'name' => 'BOX' . $box->box_id,
            ]);
        }
        return response()->json(
            'There an error with the BOX Information'
        );
    }


    public function kit(Request $request)
    {
        if (Str::substr($request->data, -4) !== '-KIT') {
            $request->data = $request->data . '-KIT';
        };

        $validated = $request->validate([
            'KitLCN' => 'exists',
        ]);

        try {
            $kit = Kit::where('KitLCN', $request->data)->first();
        } catch (Exception $e) {

            $message = $e->getMessage();
            var_dump('Exception Message: ' . $message);

            $code = $e->getCode();
            var_dump('Exception Code: ' . $code);

            $string = $e->__toString();
            var_dump('Exception String: ' . $string);

            exit;
        }


        return response()->json([
            'id' => $kit->KitID,
            'name' => $kit->KitLCN,
        ]);

        //
        //        if ($kit){
        //
        //        }
        //
        //        return response()->json(
        //            'There an error with the KIT Information',
        //        );
    }


    public function boxes(Request $request)
    {
        $this->validate($request, [
            'data' => [
                'required',
                Rule::exists('sqlsrv.bin.Boxes', 'box_name')
            ],
        ]);

        return Box::where('box_name', $request->data)->first();

    }

    public function shelf(Request $request)
    {
        $this->validate($request, [
            'data' => [
                'required',
                Rule::exists('sqlsrv.bin.Shelves', 'shelf_name')
            ],
        ]);

        return Shelf::where('shelf_name', $request->data)->first();

    }

    public function kits(Request $request, Box $box)
    {

        try {
            $kit = $box->kits()->where('KitLCN',$request->data)->first();
        } catch (Exception $e) {

            $message = $e->getMessage();
            var_dump('Exception Message: ' . $message);

            $code = $e->getCode();
            var_dump('Exception Code: ' . $code);

            $string = $e->__toString();
            var_dump('Exception String: ' . $string);

            exit;
        }

        return response()->json(
            $kit
        );

    }

    public function shelfBox(Request $request, Shelf $shelf)
    {

        try {
            $box = $shelf->boxes->where('box_name',$request->data)->first();
        } catch (Exception $e) {

            $message = $e->getMessage();
            var_dump('Exception Message: ' . $message);

            $code = $e->getCode();
            var_dump('Exception Code: ' . $code);

            $string = $e->__toString();
            var_dump('Exception String: ' . $string);

            exit;
        }
        if ($box) {
            return response()->json([
                'id' => $box->box_id,
                'name' => $box->box_name,
            ]);
        }
        return response()->json($box);

    }

}
