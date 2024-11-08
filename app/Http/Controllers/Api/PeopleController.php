<?php

namespace App\Http\Controllers\Api;

use App\Models\People;
use App\Http\Controllers\Controller;
use App\Http\Resources\PeopleResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{

    public function index(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string',
            'orderBy' => 'nullable|string|in:id,nama,nik,tanggal_lahir,nama_ayah,nama_ibu,pekerjaan_ayah,pekerjaan_ibu,created_at',
            'sort' => 'nullable|string|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $search = $request->search;
        $searchColumns = [
            'nama',
            'nik',
            'tanggal_lahir',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
        ];
        $orderBy = $request->order_by;
        $sort = $request->sort;
        $person = People::
            when($orderBy !== null, function (Builder $query) use ($orderBy, $sort) {
                $query->orderBy($orderBy, $sort);
            })->when($search, function (Builder $query) use ($search, $searchColumns) {
                $query->where(function (Builder $query) use ($search, $searchColumns) {
                    foreach ($searchColumns as $column) {
                        $query->orWhere($column, 'LIKE', '%' . $search . '%');
                    }
                });
            })
            ->paginate($request->per_page != null ? $request->per_page : 10)->onEachSide(0);
        return response()->json($person);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required',
            'tanggal_lahir' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $person = People::create([
            'nama' => $validatedData['nama'],
            'nik' => $validatedData['nik'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'nama_ayah' => $validatedData['nama_ayah'],
            'nama_ibu' => $validatedData['nama_ibu'],
            'pekerjaan_ayah' => $validatedData['pekerjaan_ayah'],
            'pekerjaan_ibu' => $validatedData['pekerjaan_ibu'],
        ]);

        return new PeopleResource(true, 'Data Berhasil Ditambahkan!', $person);
    }

    public function show($id)
    {
        $person = People::find($id);
        return response()->json($person);

        // return new PersonResource(true, 'Detail Data People', $person);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required',
            'tanggal_lahir' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $person = People::find($id);
        $validatedData = $validator->validated();
        $person->update([
            'nama' => $validatedData['nama'],
            'nik' => $validatedData['nik'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'nama_ayah' => $validatedData['nama_ayah'],
            'nama_ibu' => $validatedData['nama_ibu'],
            'pekerjaan_ayah' => $validatedData['pekerjaan_ayah'],
            'pekerjaan_ibu' => $validatedData['pekerjaan_ibu'],
        ]);
        return new PeopleResource(true, 'Data People Berhasil Diubah!', $person);
    }

    public function destroy($id)
    {
        $person = People::find($id);
        $person->delete();
        return new PeopleResource(true, 'Data Berhasil Dihapus!', null);
    }
}
