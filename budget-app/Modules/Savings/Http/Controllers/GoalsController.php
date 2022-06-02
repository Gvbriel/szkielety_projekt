<?php

namespace Modules\Savings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Savings\Entities\Goal;
use Modules\Savings\Http\Requests\StoreGoalRequest;
use Modules\Savings\Transformers\GoalResource;

class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $goals = Goal::where('user_id', Auth::user()->id)->get();

        return response()->json(GoalResource::collection($goals));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('savings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreGoalRequest $request)
    {
        $goal = Goal::create([
            'name' => $request->name,
            'goal' => $request->goal,
            'description' => $request->description,
            'currency' => $request->currency,
            'balance' => 0,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json($goal);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('savings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('savings::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(Goal::find($id)){
            $goal = Goal::find($id);
            $savings = $goal->savings;
            foreach($savings as $saving){
                $saving->delete();
            }
            $goal->delete();
            return true;
        }

    }
}
