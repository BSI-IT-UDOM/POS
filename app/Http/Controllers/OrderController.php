<?php







namespace App\Http\Controllers;







use Carbon\Carbon;



use App\Models\UOM;



use App\Models\Order;



use App\Models\Currency;



use App\Models\Material;



use App\Models\Supplier;



use App\Models\Inventory;



use App\Models\OrderInfor;



use Illuminate\Http\Request;



use App\Models\MaterialGroup;

use App\Models\MaterialCategory;

use App\Http\Controllers\Controller;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;







class OrderController extends Controller



{



    public function __construct()



    {



        $this->middleware('auth');



    }



    /**



     * Display a listing of the resource.



     *



     * @return \Illuminate\Http\Response



     */



    public function index()



    {



        $Supplier = Supplier::all();



        $materials = Material::all();



        $uom = UOM::all();



        $currency = Currency::all();



        $order = Order::all();



        $order_inf = OrderInfor::all();



        // $inventory = Inventory::all();



        $categories = MaterialCategory::all();     
        $group = MaterialGroup::all();
        $existingItems = Order::with(['material', 'uom'])
        ->get();

        $order_inf_counts = $order->groupBy('Order_Info_id')->map(function ($group) {



            return $group->count();



        });
        $groupedOrders = $order->groupBy('Order_Info_id');
        return view('order', compact('Supplier', 'materials', 'uom', 'order_inf', 'categories', 'group', 'order_inf_counts', 'currency', 'groupedOrders','existingItems')); 
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

        $request->validate([
            'Reciept_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'Total_Price' => 'required|numeric',
            'Sup_id' => 'required|integer',
            'selectnum' => 'required|integer|min:1',
        ]);
        // Handle the receipt image upload
        if ($request->hasFile('Reciept_image')) {
            $imagePath = $request->file('Reciept_image')->store('receipt_images', 'public');

        }
        // Create the OrderInfo
        $order = OrderInfor::create([
            'Order_number' =>  $request->Order_number,
            'Reciept_image' => $imagePath ?? 'null',
            'Total_Price' => $request->Total_Price,
            'Sup_id' => $request->Sup_id,
            'S_id' => Auth::user()->invshop->S_id,
            'L_id' => Auth::user()->invLocation->L_id,
            'inc_VAT' => $request->inc_VAT ? 1 : 0,
            'order_date' => $request->order_date,
            'Currency_id' => $request->Currency_id,
        ]);
        // Create the individual Orders and update expiry dates
        $numberOfMaterial = $request->selectnum;
        for ($i = 0; $i < $numberOfMaterial; $i++) {
            $materialId = $request->input("inputSelectMaterial".($i+1));
            // Create the Order
            Order::create([
                'Order_Info_id' => $order->Order_Info_id,
                'Material_id' => $materialId,
                'Material_Qty' => $request->input("QtyMaterial".($i+1)),
                'UOM_id' => $request->input("inputSelectUOM".($i+1)),
                'Order_Qty' => $request->input("Material_Qty".($i+1)),
                'price' => $request->input("price".($i+1)),
                'sub_total' => $request->input("sub_total".($i+1)),
                'Currency_id' =>  $order->Currency_id,
                'expiry_date' => $request->input("expired_Date".($i+1)),
            ]);
        }
        return redirect()->back()->with('success', 'Order created successfully!');
    }



    







    /**



     * Display the specified resource.



     *



     * @param  \App\Models\Orders  $orders



     * @return \Illuminate\Http\Response



     */



    public function show(Order $orders)



    {



        //



    }







    /**



     * Show the form for editing the specified resource.



     *



     * @param  \App\Models\Orders  $orders



     * @return \Illuminate\Http\Response



     */



    public function edit(Order $orders)



    {



        //



    }







    /**



     * Update the specified resource in storage.



     *



     * @param  \Illuminate\Http\Request  $request



     * @param  \App\Models\Orders  $orders



     * @return \Illuminate\Http\Response



     */



     public function update(Request $request, Order $order, OrderInfor $orderInfor, $id)
     {
        // dd($request->all());
         $request->validate([
             'Total_Price' => 'required|numeric',
             'Sup_id' => 'required|integer',
             'Currency_id' => 'required|integer',
             'order_date' => 'required|date',
             'inputSelectMaterial' => 'required|array',
             'QtyMaterial' => 'required|array',
             'inputSelectUOM' => 'required|array',
             'Material_Qty' => 'required|array',
             'price' => 'required|array',
             'sub_total' => 'required|array',
             'expired_Date' => 'required|array',
             'Reciept_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
     
         $orderInfor = OrderInfor::findOrFail($id);
     
         // Handle the receipt image upload
         $imagePath = $orderInfor->Receipt_image; // Default to current image if no new image is uploaded
         if ($request->hasFile('Reciept_image') && $request->file('Reciept_image')->isValid()) {
             // Delete old image if it exists
             if ($orderInfor->Receipt_image && Storage::disk('public')->exists($orderInfor->Receipt_image)) {
                 Storage::disk('public')->delete($orderInfor->Receipt_image);
             }
     
             // Store new image
             $Receipt_image = $request->file('Reciept_image');
             $imagePath = $Receipt_image->store('receipt_images', 'public');
         }
     
         // Update OrderInfor

     
    // Retrieve inputs
    $materials = $request->input('inputSelectMaterial');
    $quantities = $request->input('QtyMaterial');
    $uoms = $request->input('inputSelectUOM');
    $orderQtys = $request->input('Material_Qty');
    $prices = $request->input('price');
    $subtotals = $request->input('sub_total');
    $expiryDates = $request->input('expired_Date');
    foreach ($materials as $index => $materialId) {
        // Update or create the order
        Order::updateOrCreate(
            [
                'Order_Info_id' => $orderInfor->Order_Info_id, 
                'Material_id' => $materialId,
            ],
            [
                'Material_id' => $materials[$index],
                'Material_Qty' => $quantities[$index],
                'UOM_id' => $uoms[$index],
                'Order_Qty' => $orderQtys[$index],
                'price' => $prices[$index],
                'sub_total' => $subtotals[$index],
                'Currency_id' => $request->Currency_id,
                'expiry_date' => $expiryDates[$index],
            ]
        );
    }
    $orderInfor->update([
        'Order_number' => $request->Order_number,
        'Total_Price' => $request->Total_Price,
        'Sup_id' => $request->Sup_id,
        'inc_VAT' => $request->has('inc_VAT') ? 1 : 0,
        'order_date' => $request->order_date,
        'Currency_id' => $request->Currency_id,
        'Receipt_image' => $imagePath, // Update image path
    ]);

    return redirect()->back()->with('success', 'Order updated successfully!');
}
     







    /**



     * Remove the specified resource from storage.



     *



     * @param  \App\Models\Orders  $orders



     * @return \Illuminate\Http\Response



     */



    public function destroy( $Order_Info_id)



    {

       
        OrderInfor::destroy($Order_Info_id);



        return redirect('order')->with('flash_message', 'orders deleted!');



    }



    public function search(Request $request)



    {



        $searchTerm = $request->input('search');



        $suppliers = OrderInfor::where('Order_number', 'LIKE', "%{$searchTerm}%")->get();



    



        $output = '';



        foreach ($suppliers as $index => $data) {



            $rowClass = ($index % 2 === 0) ? 'bg-zinc-200' : 'bg-zinc-300';



            $borderClass = ($index === 0) ? 'border-t-4' : '';



            



            $output .= '



            <tr class="' . $rowClass . ' text-base ' . $borderClass . ' text-center border-white">



                <td class="py-3 px-4 border border-white">' . ($data->Order_Info_id ?? 'null') . '</td>



                <td class="py-3 px-4 border border-white">' . ($data->Order_number ?? 'null') . '</td>



                <td class="flex items-center justify-center py-3 px-4 border border-white"><img src="' . asset('storage/' . $data->Reciept_image) . '" alt="Shop Logo" class="h-10 w-12 rounded"></td>



                <td class="py-3 px-4 border border-white">' . ($data->Total_Price ?? 'null') . '</td>



                <td class="py-3 px-4 border border-white">' . ( $order_inf_counts[$data->Order_Info_id] ?? '0') . '</td>



                <td class="py-3 border border-white">



                    <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group" onclick="openEditPopup(' . $data->Sup_id . ', \'' . $data->Sup_name . '\', \'' . $data->Sup_contact . '\', \'' . $data->Sup_address . '\')">



                        <i class="fas fa-edit fa-xs"></i>



                        <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Edit</span>



                    </button>



                    <button class="relative bg-red-500 hover:bg-red-600 active:bg-red-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group" onclick="if(confirm(\'Are you sure you want to delete?\')) { window.location.href=\'order/destroy/' . $data->Order_Info_id . '\'; }">



                        <i class="fas fa-trash-alt fa-xs"></i>



                        <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Delete</span>



                    </button>



                    <button class="relative bg-green-500 hover:bg-green-600 active:bg-green-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group">



                        <i class="fas fa-toggle-on fa-xs"></i>



                        <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Active</span>



                    </button>



                </td>



            </tr>';



        }



        



        return response()->json(['html' => $output]);



    }



    



    



}



