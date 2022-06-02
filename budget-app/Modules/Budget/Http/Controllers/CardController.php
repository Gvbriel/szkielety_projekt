<?php

namespace Modules\Budget\Http\Controllers;

use Modules\Budget\Http\Controllers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Budget\Entities\Budget;
use Modules\Budget\Entities\Card;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Budget\Entities\Image;
use Modules\Budget\Transformers\CardResource;
use Modules\Budget\Transformers\CardSingleResource;


class CardController extends Controller
{

    public function getCardsSum(){

    }

    public function sortedCards()
    {
//        $c = Card::all();
//        $ca = $c->where('owner_id', Auth::user()->id);

        $cards = Card::where('owner_id', Auth::user()->id)->get()->groupBy('type')->toArray();
        $types = ['Credit', 'Debit'];
        $return = [];
        foreach ($types as $type) {
            $cards[$type] = array_map(function ($card) {
                return array(
                    'id' => $card['id'],
                    'value' => $card['id'],
                    'label' => $card['name'],
                );
            }, $cards[$type]);

            $return[] = [
                'label' => $type,
                'types' => $cards[$type]];
        }
        return response()->json($return);
    }

    public function storeImages(Request $request)
    {
        $img = Image::create([
            'name' => $request->name,
            'url' => $request->url
        ]);

        return response()->json($img);
    }

    public function getImages()
    {
        $images = Image::all();

        return response()->json($images);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $cards = CardResource::collection(Card::where('owner_id', Auth::user()->id)->paginate());
            return response()->json($cards);
        } catch (\Illuminate\Database\QueryException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('budget::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $card = Card::create([
            'name' => $request->name,
            'number' => $request->number,
            'type' => $request->type,
            'balance' => 0,
            'initial_balance' => (double)$request->balance,
            'owner_id' => Auth::user()->id,
            'image_id' => $request->image_id ?: "0",
        ]);

        return response()->json($card);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return response()->json(new CardSingleResource(Card::find($id)));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);
        $card->update($request);
        $card->save();

        return response()->json($card);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Card::find($id)) {
            $budgets = Budget::where('card_id', $id)->get();

            foreach ($budgets as $budget) {
                $budget->card_id = 0;
                $budget->save();
            }
            Card::find($id)->delete();
        }

        return true;
    }
}
