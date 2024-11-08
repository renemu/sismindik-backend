<?php

namespace App\Http\Controllers\Api;

use App\Models\code_regis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class code_regisController extends Controller
{
    //
    public function index()
    {
        $data = code_regis::all();
        
        return response()->json($data, 200);

    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'          =>'required',
            'code'        =>'required'
            // 'confirm_code'  =>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('code');
        if(!$input = ($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'Code Salah'
            ], 401);
        }
         return response()->json([
             'message' => 'Success',
             $input
             ]
         , 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'code'          => 'required',
            'confirm_code'  => 'required',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $validatedData = $validator->validated();
        $data = code_regis::create([
            'name'          => $validatedData['name'],
            'code'          => $validatedData['code'],
            'confirm_code'  => $validatedData['confirm_code']
        ]);
         return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'code'          => 'required',
            'confirm_code'  => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $data = code_regis::find($id);
        $validatedData = $validator->validated();
        $data->update([
            'name'          => $validatedData['name'],
            'code'          => $validatedData['code'],
            'confirm_code'  => $validatedData['confirm_code'],
        ]);
        return response()->json($data, 200);
    }

}
