<?php



namespace App\Http\Controllers;



use App\Models\UOM;

use App\Models\Material;

use App\Models\Currency;

use App\Models\Inventory;

use App\Models\Supplier;

use Illuminate\Http\Request;

use App\Models\MaterialCategory;
use App\Models\MaterialGroup;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;



class InventoryController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $group = MaterialGroup::all();
        $categories = MaterialCategory::all();

        $Supplier = Supplier::all();

        $materials = Material::all();

        $uom = UOM::all();

        $currency = Currency::all();

        $inventory = Inventory::with(['invShop', 'location'])

        ->where('S_id', Auth::user()->invshop->S_id)

        ->where('L_id', Auth::user()->invLocation->L_id)

        ->paginate(10);
        return view('inventory', compact('group', 'categories','inventory','Supplier','materials','uom','currency')); 

    }

    

    public function __construct()

    {

        $this->middleware('auth');

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

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

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function show(Inventory $inventory)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function edit(Inventory $inventory)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Inventory $inventory)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function destroy(Inventory $inventory)

    {

        //

    }

    //search

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $inventory = Inventory::where('Material_Khname', 'LIKE', "%{$searchTerm}%")
            ->orWhere('Material_Engname', 'LIKE', "%{$searchTerm}%")
            ->orWhere('Category', 'LIKE', "%{$searchTerm}%")
            ->get();
    
        $output = '';
    
        if ($inventory->isEmpty()) {
            return response()->json([
                'html' => '
                <tr>
                    <td colspan="8" class="flex items-center justify-center h-48 w-full text-center">
                        <div>
                            <h2 class="text-gray-700 text-2xl font-bold">🚫 No Results Found</h2>
                            <p class="text-gray-500 text-lg mt-2">Try searching with a different keyword.</p>
                        </div>
                    </td>
                </tr>
                '
            ]);
        } else {
            foreach ($inventory as $data) {
                $output .= '
                <tr class="bg-zinc-200 text-base border-t-4 border-white">
                    <td class="py-3 px-4 border border-white">'.$data->Material_Khname . ' ' . $data->Material_Engname.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->Category.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->old_stock_qty.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->old_stock_expiry_date.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->new_stock_qty.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->new_stock_expiry_date.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->Total_In_Hand.'</td>
                    <td class="py-3 px-4 border border-white">'.$data->UOM.'</td>
                </tr>';
            }
        }
    
        return response()->json(['html' => $output]);
    }

}

