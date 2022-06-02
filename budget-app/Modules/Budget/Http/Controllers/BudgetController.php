<?php

namespace Modules\Budget\Http\Controllers;

use Modules\Budget\Http\Controllers\ResponseHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Budget\Entities\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Budget\Entities\Category;
use Modules\Budget\Http\Requests\StoreCategoryRequest;
use Modules\Budget\Transformers\BudgetResource;
use Modules\Budget\Http\Requests\StoreBudgetRequest;
use Modules\Budget\Http\Requests\UpdateBudgetRequest;

class BudgetController extends Controller
{
    public function getDataForDonutChart()
    {
        $budget = Budget::where('user_id', Auth::user()->id)->where('type', 'Spending')->get()->sortBy('id')->groupBy('category_id');
        $budg = [];
        $val = 0;
        foreach ($budget as $key => $bud)
        {
            foreach ($bud as $b)
            {
                $val += $b->amount;
            }
            $cat = Category::find($key);
            $budg[] = ['name' => $cat->name, 'value' => $val, 'color' => "am4core.color(" . '"' . $cat->color . '"' . ')'];
            $val = 0;
        }

        return response()->json($budg);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $budget = ResponseHelper::getPagination(BudgetResource::collection(Budget::where('user_id', Auth::user()->id)->paginate()));
        return response()->json($budget);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreBudgetRequest $request)
    {
        //$card = Auth::user()->cards;
        if (is_null($request->description)) {
            $desc = '';
        } else {
            $desc = $request->description;

        }

        $budget = Budget::create([
            'amount' => $request->amount,
            'title' => $request->title,
            'date' => Carbon::parse($request->date)->toDateTimeString(),
            'description' => $desc,
            'type' => $request->type,
            'is_recurring' => $request->is_recurring,
            'user_id' => Auth::user()->id,
            'card_id' => $request->card_id,
            'category_id' => $request->category_id,
        ]);

        return response()->json($budget);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $budget = Budget::find($id);

        return response()->json($budget);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateBudgetRequest $request, $id)
    {
        $budget = Budget::find($id);
        $budget->amount = $request->amount;
        $budget->title = $request->title;
        $budget->date = Carbon::parse($request->date)->toDateTimeString();
        $budget->description = $request->description;
        $budget->type = $request->type;
        $budget->is_recurring = $request->is_recurring;
        $budget->card_id = $request->card_id;
        $budget->category_id = $request->category_id;
        $budget->save();

        return response()->json($budget);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Budget::find($id)->delete();

        return true;
    }
}
