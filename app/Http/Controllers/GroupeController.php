<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
   protected $user;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
       /* $tasks = $this->user->tasks()->get(['title', 'description'])->toArray();*/
        $groupes=Groupe::all();

        return $groupes;
    }

    public function show($id)
    {
       /* $task = $this->user->tasks()->find($id);*/
        $groupe=Groupe::where('groupeId',$id)->first();
        //dd($groupe->stagiaires);
        if (!$groupe) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, group with id ' . $id . ' cannot be found.'
            ], 400);
        }

        return $groupe;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $groupe = new Groupe();
        $groupe->name = $request->name;


        if ($groupe->save())
            return response()->json([
                'success' => true,
                'groupe' => $groupe
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, group could not be added.'
            ], 500);
    }

    public function update(Request $request, $id)
    {
       $groupe=Groupe::where('groupeId',$id)->first();

        if (!$groupe) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, group with id ' . $id . ' cannot be found.'
            ], 400);
        }

        $groupe->name=$request->name;
        $updated=$groupe->save();


        if ($updated) {
            return response()->json([
                'success' => true,
                'groupe'=> $groupe
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, group could not be updated.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $groupe=Groupe::where('groupeId',$id)->first();

        if (!$groupe) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, group with id ' . $id . ' cannot be found.'
            ], 400);
        }

        if ($groupe->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'group could not be deleted.'
            ], 500);
        }
    }
}
