<?php







namespace App\Http\Controllers;







use App\Models\Income;
use App\Models\IncomeCate;
use App\Models\Currency;
use Illuminate\Http\Request;







class IncomeController extends Controller



{



    /**



     * Display a listing of the resource.



     *



     * @return \Illuminate\Http\Response



     */



    public function index()



    {

        $incomeCat= IncomeCate::all();
        $income= Income::all();
        $currency = Currency::all();
        return view('income', compact('income', 'incomeCat', 'currency'));



    }







    /**



     * Show the form for creating a new resource.



     *



     * @return \Illuminate\Http\Response



     */



    public function create(Request $request)



    {



        {



            $validatedData = $request->validate([

    

                'income_name' => 'required|string|max:255',

    

                'references_doc' => 'nullable|string|max:255',

    

                'IC_id' => 'required|integer',

    

                'income_date' => 'nullable|date',

    

            ]);

    



    

    

            Income::create($validatedData);

    

    

    

            // Redirect or return response

    

            return redirect()->back()->with('success', 'Income added successfully!');

    

        }

    



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



     * @param  \App\Models\Income  $Income



     * @return \Illuminate\Http\Response



     */



    public function show(Income $Income)



    {



        //



    }







    /**



     * Show the form for editing the specified resource.



     *



     * @param  \App\Models\Income  $Income



     * @return \Illuminate\Http\Response



     */



    public function edit(Income $Income)



    {



        //



    }







    /**



     * Update the specified resource in storage.



     *



     * @param  \Illuminate\Http\Request  $request



     * @param  \App\Models\Income  $Income



     * @return \Illuminate\Http\Response



     */



    public function update(Request $request, Income $Income)



    {



        //



    }







    /**



     * Remove the specified resource from storage.



     *



     * @param  \App\Models\Income  $Income



     * @return \Illuminate\Http\Response



     */



    public function destroy(Income $Income)



    {



        //



    }



}



