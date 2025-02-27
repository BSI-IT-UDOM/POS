<?php







namespace App\Http\Controllers;







use App\Models\Expense;
use App\Models\ExpenseCate;
use App\Models\Currency;
use Illuminate\Http\Request;







class ExpenseController extends Controller



{



    /**



     * Display a listing of the resource.



     *



     * @return \Illuminate\Http\Response



     */



    public function index()



    {

        $expenseCat= ExpenseCate::all();
        $expense= Expense::all();
        $currency = Currency::all();
        return view('expense', compact('expense', 'expenseCat', 'currency'));



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

    

                'Exp_name' => 'required|string|max:255',

    

                'references_doc' => 'nullable|string|max:255',

    

                'IEC_id' => 'required|integer',

    

                'Exp_date' => 'nullable|date',

    

            ]);

    



    

    

            Expense::create($validatedData);

    

    

    

            // Redirect or return response

    

            return redirect()->back()->with('success', 'Expense added successfully!');

    

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



     * @param  \App\Models\Expense  $expense



     * @return \Illuminate\Http\Response



     */



    public function show(Expense $expense)



    {



        //



    }







    /**



     * Show the form for editing the specified resource.



     *



     * @param  \App\Models\Expense  $expense



     * @return \Illuminate\Http\Response



     */



    public function edit(Expense $expense)



    {



        //



    }







    /**



     * Update the specified resource in storage.



     *



     * @param  \Illuminate\Http\Request  $request



     * @param  \App\Models\Expense  $expense



     * @return \Illuminate\Http\Response



     */



    public function update(Request $request, Expense $expense)



    {



        //



    }







    /**



     * Remove the specified resource from storage.



     *



     * @param  \App\Models\Expense  $expense



     * @return \Illuminate\Http\Response



     */



    public function destroy(Expense $expense)



    {



        //



    }



}



