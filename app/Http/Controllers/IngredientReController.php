<?php



namespace App\Http\Controllers;



use App\Models\IngredientRe;

use Illuminate\Http\Request;



class IngredientReController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

     public function create(Request $request)
     {
         $validatedData = $request->validate([
             'IIQ_id' => 'required|array', 
             'IIQ_id.*' => 'required|integer', 
             'Menu_id' => 'required|integer',
         ]);
         foreach ($validatedData['IIQ_id'] as $IIQ_id) {
             IngredientRe::create([
                 'IIQ_id' => $IIQ_id, // Current IIQ_id
                 'Menu_id' => $validatedData['Menu_id'], 
             ]);
         }
     
         return redirect()->back()->with('success', 'Ingredients added successfully!');
     }
     


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  \App\Models\IngredientRe  $ingredientRe

     * @return \Illuminate\Http\Response

     */

    public function show(IngredientRe $ingredientRe)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\IngredientRe  $ingredientRe

     * @return \Illuminate\Http\Response

     */

    public function edit(IngredientRe $ingredientRe)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\IngredientRe  $ingredientRe

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, IngredientRe $ingredientRe)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\IngredientRe  $ingredientRe

     * @return \Illuminate\Http\Response

     */

    public function destroy(IngredientRe $ingredientRe)

    {

        //

    }

}

