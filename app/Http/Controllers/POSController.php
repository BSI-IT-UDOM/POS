<?php

namespace App\Http\Controllers;

use App\Models\POS;

use App\Models\Currency;

use App\Models\Menu;

use App\Models\MenuGroup;

use App\Models\Addon;

use App\Models\InvStock;

use App\Models\invSize;

use App\Models\InHand;

use App\Models\pos\Table;

use App\Models\pos\MenuDetail;
use App\Models\invMenuCate;

use App\Models\IngredientRe;

use App\Models\pos\POSOrder;

use App\Models\pos\POSCheckBill;

use App\Models\PaymentMethod;

use Illuminate\Http\Request;

use App\Models\IngredientQty;

use App\Models\pos\DiscountDetail;

use App\Models\pos\POSOrderDetail;

use App\Http\Controllers\Controller;

use App\Models\Material;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Http;



class POSController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth');

    }

    public function index()

    {

        $menus = Menu::all();

        $addons = Addon::all();

        $table = Table::all(); 

        $posDetails = POSOrderDetail::with('posOrder', 'menu')

            ->whereHas('posOrder', function($query) {

                $query->where('status', '!=', 'FINISHED');

            })->get(); 

        $checkStatus = POSOrder::where('status', 'ORDERED')->get(['pos_table_id']);

    

        return view('pos', compact('menus', 'addons', 'table', 'checkStatus', 'posDetails'));

    }

    public function show(POS $pOS, Request $request)

    {

        $size = invSize::all();

        $posDetails = POSOrderDetail::with('posOrder', 'menu')

            ->whereHas('posOrder', function($query) {

                $query->where('status', '!=', 'FINISHED');

            })->get();

        $currency = Currency::all();

        $payment = PaymentMethod::all();

        $menuGr = MenuGroup::all();

        $menuAll = Menu::all();

        $queryString = $request->getQueryString(); 

        $pos_table_id = rtrim($queryString, '=');  

        $tableStatus = POSOrder::where('pos_table_id', $pos_table_id)

                                ->where('status', 'ORDERED')

                                ->value('status');

        $orderID = POSOrder::where('pos_table_id', $pos_table_id)

                            ->where('status', 'ORDERED')

                            ->value('pos_order_id');

        $order = POSOrder::where('pos_order_id', $orderID)->get();

        $orderDetail = POSOrderDetail::where('pos_order_id', $orderID)

                                    ->get();

        $menuCat = invMenuCate::all();

        $addons = Addon::all();

        $menus = Menu::with('menuCategory')

                    ->with('menuDetail')->get();

        $discountDetail = DiscountDetail::all();

        $categories = [];

        foreach ($menus as $menu) {

            $categories[$menu->Menu_Cate_id][] = $menu;

            // dd($menu);

        }

        //Pass the pos_table_id to the view

        return view('pos.show-table', compact('categories', 'addons', 'menuCat', 'discountDetail', 'pos_table_id', 'menuAll', 'menuGr', 'tableStatus', 'order', 'orderDetail', 'payment', 'currency', 'posDetails', 'size'));

    }

    public function create()

    {

    }



    public function store(Request $request)

    {

        $request->validate([

            'shop' => 'required',

            'location' => 'required',

            'menuid' => 'required',

            'menuname' => 'required',

            'addon_id' => 'required',

            'addon_name' => 'required',

            'quantity' => 'required|integer|min:1',

            'price' => 'required|numeric|min:0',

            'currency' => 'required',

            'date' => 'required|date',

        ]);

        $data = $request->all();;

        $ingredientRe = IngredientRe::where('Menu_id', $data['menuid'])->first();

        

        if (!$ingredientRe) {

            return back()->with('error', 'No ingredient record found for this menu.');

        }

        $iiq_id = $ingredientRe->IIQ_id;

        $ingredientQtys = IngredientQty::where('IIQ_id', $iiq_id)->get();

        if ($ingredientQtys->isEmpty()) {

            return back()->with('error', 'No materials found for these ingredients.');

        }

        foreach ($ingredientQtys as $ingredientQty) {

            $material_id = $ingredientQty->Material_id;

            $stock = InvStock::where('Material_id', $material_id)->first();

            if (!$stock) {

                return back()->with('error', 'Material not available in stock for Material ID: ' . $material_id);

            }

        }

        $currency = $request->input('currency') == 'KHR' ? 'Riel(s)' : $request->input('currency');

        $apiData = [

            'shop_name' => $data['shop'],

            'location_Name' => $data['location'],

            'Khmer_name' => '', 

            'Eng_name' => $data['menuname'],

            'addons' => $data['addon_name'] ?? '',

            'qty' => $data['quantity'],

            'price' => $data['price'],

            'date' => $data['date'],

            'currency' => $currency,

        ];

        $response = Http::withoutVerifying()->post('https://api.bsi.com.kh/inventorybsi', $apiData);

        if ($response->successful()) {

            return redirect()->back()->with('success', $data['menuname'] . ' was sold out ' . $data['quantity'] . ' glass(s) with a price of $' . $data['price'] . ' ' . $currency);

        } else {

            return back()->with('error', 'Failed to submit data to the API.');

        }

    }

    public function submitOrder(Request $request)

    {  

        $validatedData = $request->validate([

            'order_number' => 'required',

            'pos_table_id' => 'required',

            'sub_total' => 'required',

            'pos_discount_detail_id' => 'required',

            'discount_amount' => 'required',

            'grand_total' => 'required',

            'order_date' => 'required|date',

            'order_data' => 'required|json', 

        ]);

        $orderData = json_decode($validatedData['order_data'], true);

        foreach ($orderData as $menuID) {

            $ingredientRe = IngredientRe::where('Menu_id', $menuID['Menu_id'])->first();

        

            if (!$ingredientRe) {

                return back()->with('error', 'No ingredient record found for this menu.');

            }

            $iiq_id = $ingredientRe->IIQ_id;

            $ingredientQtys = IngredientQty::where('IIQ_id', $iiq_id)->get();

            if ($ingredientQtys->isEmpty()) {

                return back()->with('error', 'No materials found for these ingredients.');

            }

            foreach ($ingredientQtys as $ingredientQty) {

                $material_id = $ingredientQty->Material_id;

                $material_name = Material::where('Material_id', $material_id)->value('Material_Engname');

                $in_hand = InHand::where('Material_id', $material_id)->first();

                if (!$in_hand) {

                    return back()->with('error', 'Material not available in stock for Material Name: ' . $material_name);

                }else{

                    if($in_hand->NewQty < $ingredientQty->Qty){

                        return back()->with('error', 'Not enough quantity in stock for Material Name: ' . $material_name);

                    }else{

                        if ($in_hand->NewQty < $menuID['Qty']) {

                            return back()->with('error', 'Material available in stock for only: ' . $in_hand->NewQty);

                        }

                    }

                }

            }

        }

        // Create the POS order

        $posOrder = POSOrder::create([

            'order_number' => $validatedData['order_number'],

            'sub_total' => $validatedData['sub_total'],

            'pos_table_id' => $validatedData['pos_table_id'],

            'pos_discount_detail_id' => $validatedData['pos_discount_detail_id'],

            'discount_amount' => $validatedData['discount_amount'],

            'grand_total' => $validatedData['grand_total'],

            'order_date' => $validatedData['order_date'],

        ]);

        $orderDetails = [];

        foreach ($orderData as $item) {

            $orderDetails[] = [

                'pos_order_id' => $posOrder->pos_order_id, 

                'Menu_id' =>$item['Menu_id'],

                'Qty' => $item['Qty'],

                'Addons_id' =>$item['Addons_id'],

                'Size_id' =>$item['Size_id'],

                'price' => $item['price'], 

            ];

        }

        POSOrderDetail::insert($orderDetails);

        return redirect()->route('pos')->with('success', 'Order has been submitted successfully!');

    }

    public function edit(POS $pOS)

    {

    }

    public function update(Request $request, POS $pOS)

    {

    }

    public function destroy(POS $pOS)

    {

    }

    public function checkBill(Request $request)

        {

            // dd($request->all());

            $validatedData = $request->validate([

                'pos_order_id' => 'required|integer',

                'IPM_id' => 'required|integer',

                'Currency_id' => 'required|integer',

            ]);

            POSCheckBill::create($validatedData);

            return redirect()->route('pos')->with('success', 'CHECK BILL has been submitted successfully!');

        }    

}