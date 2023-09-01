<?php

namespace App\Http\Controllers;

use App\Models\Text;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
//use DataTables;

class TextController extends Controller
{
    public function index()
    {

        return view('welcome');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('term', '');

        $texts = Text::where('manager', 'LIKE', '%' . $query . '%')
            ->orderBy('manager', 'asc')
            ->get();

        $data = [];
        foreach ($texts as $text) {
            $data[] = [
                'id' => $text->id,
                'value' => $text->manager,
            ];
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $text = new Text();
        $text->manager = $request->input('manager');
        $text->save();

        return response()->json(['message' => 'Text saved successfully']);
    }

    public function getData(Request $request)
    {

        if ($request->ajax()) {
            $data = Text::all();
            return datatables()->of($data)
                ->addColumn('manager', function ($transaction) {
                    // Add any additional action buttons or HTML here
                    return $transaction->manager;
                })
                ->addColumn('created_at', function ($transaction) {
                    // Add any additional action buttons or HTML here
                    return $transaction->created_at;
                })
                ->rawColumns([
                    'manager','created_at'
                ])
                ->make(true);
        }
    }
}
