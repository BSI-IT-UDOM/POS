<?php

namespace App\Http\Controllers;



use App\Models\UOM;

use App\Models\Menu;

use App\Models\User;

use App\Models\Addon;

use App\Models\Income;

use App\Models\Module;

use App\Models\InvRole;

use App\Models\Invshop;

use App\Models\invSize;
use App\Models\Setting;

use App\Models\Currency;

use App\Models\Employee;

use App\Models\InvOwner;

use App\Models\Material;

use App\Models\Position;

use App\Models\LoginInfo;
use App\Models\MenuGroup;
use App\Models\pos\Table;

use App\Models\SysModule;

use App\Models\IncomeCate;

use App\Models\ExpenseCate;

use App\Models\InvLocation;

use App\Models\invMenuCate;

use App\Models\PaymentCate;

use App\Models\IngredientRe;

use App\Models\OperationLog;

use App\Models\pos\Discount;

use App\Models\pos\POSOrder;

use Illuminate\Http\Request;

use App\Models\IngredientQty;

use App\Models\MaterialGroup;

use App\Models\PaymentMethod;

use App\Models\pos\Promotion;

use App\Models\pos\MenuDetail;

use App\Models\MenuIngredients;

use App\Models\MaterialCategory;

use App\Models\pos\PromotionType;

use App\Models\pos\DiscountDetail;

use App\Models\pos\POSOrderDetail;

use App\Models\pos\PromotionDetail;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class SettingController extends Controller

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

        $discountDetail = DiscountDetail::all();

        $discount = Discount::all();

        $menuDetail = MenuDetail::all();

        $posOrder = POSOrder::all();

        $posOrderDetail = PosOrderDetail::all();

        $promotionDetail = PromotionDetail::all();

        $promotion = Promotion::all();

        $promotionType = PromotionType::all();

        $table = Table::all();

        $size = invSize::all();

        $payment = PaymentMethod::all();

        $paymentCate = PaymentCate::all();

        $materialGroup = MaterialGroup::all();

        $materialCate = MaterialCategory::all();

        $menuCate = invMenuCate::all();

        $user = User::all();

        $uom = UOM::all();

        $material = Material::all();

        $menuIngredients = MenuIngredients::all()->groupBy('Menu_id');

        $invMenu = Menu::paginate(12);

        $shop = Invshop::paginate(2);

        $shop_se =Invshop::all();

        $role = InvRole::all();

        $module = SysModule::all();

        $moduleInf = Module::all();

        $location = InvLocation::all();

        $group = MenuGroup::all();

        $expense = ExpenseCate::all();

        $income = Income::all();

        $incomeCate = IncomeCate::all();

        $ingredientQty = IngredientQty::all();

        $currency = Currency::all();

        $dropdownMenu = Menu::all();

        return view('setting', compact('discountDetail', 'discount', 'menuDetail', 'posOrder', 'posOrderDetail', 'promotion', 'promotionType', 'promotionDetail', 'table', 'material','materialCate','menuCate','user', 'payment', 'paymentCate', 'invMenu','shop','role','module', 'size','moduleInf','uom','shop_se','location','group','expense','menuIngredients','ingredientQty','currency', 'materialGroup', 'dropdownMenu', 'income', 'incomeCate')); 

    }







    public function shop ()

    {

        $shop = Invshop::all();

        $shop = Invshop::paginate(2);

        $shop_se =Invshop::all();

        return view('setting.shop', compact('shop','shop_se'));

    }



    public function ShopOperation(Request $request)

    {
        $shop = Auth::user()->invShop->O_id;

        // Validate the input data

        $validatedData = $request->validate([

            'S_name' => ['required', 'string', 'max:255'],

            'S_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        // Handle the file upload if a logo is provided

        $logoPath = null;

        if ($request->hasFile('S_logo') && $request->file('S_logo')->isValid()) {

            $logo = $request->file('S_logo');

            $logoPath = $logo->store('logos', 'public'); // Store under 'public/storage/logos'

        }

        // Create the shop record in the database

        Invshop::create([

            'S_name' => $validatedData['S_name'],

            'O_id' => $shop, // Assuming this is intentionally left empty

            'S_logo' => $logoPath,

        ]);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Shop Was Created Successfully!');

    }



    public function location ()

    {

        $location = InvLocation::all();

        $location = InvLocation::paginate(2);

        return view('setting.location', compact('location', 'location'));

    }





    public function upddatelocation(Request $request)

    {

        // Validate the input data

        $validatedData = $request->validate([

            'L_name' => ['required', 'string', 'max:255'],

            'L_address' => ['required', 'string', 'max:255'],

            'L_contact' => ['required', 'string', 'max:255'],

            'S_id' => 'required|integer',

        ]);

        // Create the location record in the database

        InvLocation::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Location created successfully!');

    }



    public function createUser(Request $request) {
        $data = $request->validate([
            'U_name' => ['required', 'string', 'max:255'],
            'sys_name' => ['required', 'string', 'max:255'],
            'U_contact' => ['required', 'string', 'max:255'],
            'R_id' => 'required|integer',
            'S_id' => 'required|integer',
            'L_id' => 'required|integer',
            'emp_id' => 'required|integer',
            'password' => ['required', 'string', 'min:8'], 
            'U_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        
        $photoPath = null;
        if ($request->hasFile('U_photo')) {
            $photo = $request->file('U_photo');
            if ($photo->isValid()) {
                $photoPath = $photo->store('user_photos', 'public');
            };
        // Create the user
        User::create([
            'U_name' => $data['U_name'],
            'R_id' => $data['R_id'],
            'U_contact' => $data['U_contact'],
            'sys_name' => $data['sys_name'],
            'password' => Hash::make($data['password']), 
            'S_id' => $data['S_id'],
            'L_id' => $data['L_id'],
            'emp_id' => $data['emp_id'],
            'U_photo' =>$photoPath, 
            'status' => 'Active',
        ]);
    }
        // Redirect back with a success message
        return redirect()->back()->with('success', 'User created successfully!');
    }

    
    public function viewUser(Request $request) {
        $user = User::all();
        $role = InvRole::all();
        $location = InvLocation::all();
        $employees = Employee::all();
        $shop_se =Invshop::all();
        return view('setting.user', compact('user', 'role', 'location', 'shop_se','employees'));
    }



        public function toggleStatus(Request $request, $id)

    {

        $loggedInUserId = auth()->id();

        if ($loggedInUserId == $id) {

            return response()->json(['success' => false, 'message' => 'You cannot change your own status.'], 403);

        }

        $user = User::findOrFail($id);

        $user->status = $request->status;

        $user->save();

        return response()->json(['success' => true]);

    }





    public function update(Request $request, $S_id)

    {
        // Validate the input data

        $validatedData = $request->validate([

            'S_name' => 'required|string|max:255',

            'S_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        $shop = Invshop::findOrFail($S_id);

        $shop->S_name = $validatedData['S_name'];

        if ($request->hasFile('S_logo') && $request->file('S_logo')->isValid()) {

            // Delete the old image if it exists

            if ($shop->S_logo && Storage::disk('public')->exists($shop->S_logo)) {

                Storage::disk('public')->delete($shop->S_logo);

            }  

            $s_logo = $request->file('S_logo');

            $imagePath = $s_logo->store('logos', 'public');

            $shop->S_logo = $imagePath;

        }    

        // Save the updated shop record

        $shop->save();

        // Redirect or return a response

        return redirect()->back()->with('success', 'Shop updated successfully!');

    } 



    public function updateUser(Request $request, $U_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'U_name' => 'required|string|max:255',

            'U_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'R_id' => 'required|integer',

            'sys_name' => 'required|string|max:255',

            'U_contact' => 'required|string|max:255',

            'password' => ['required', 'string', 'min:8'],

            'newpassword' => 'nullable|string|min:8', 

        ]);

        // Find the user record by ID

        $user = User::findOrFail($U_id);

        // Update user details

        $user->U_name = $validatedData['U_name'];

        $user->R_id = $validatedData['R_id'];

        $user->sys_name = $validatedData['sys_name'];

        $user->U_contact = $validatedData['U_contact'];

        // Handle password update

        if ($request->filled('newpassword')) {

            $user->password = bcrypt($request->input('newpassword'));

        }

        // Handle the image upload if a new image is provided

        if ($request->hasFile('U_photo') && $request->file('U_photo')->isValid()) {

            // Delete the old image if it exists

            if ($user->U_photo && Storage::disk('public')->exists($user->U_photo)) {

                Storage::disk('public')->delete($user->U_photo);

            }

            // Store the new image and update the U_photo field

            $photo = $request->file('U_photo');

            $imagePath = $photo->store('profile_pics', 'public');

            $user->U_photo = $imagePath;

        }

        // Save the updated user record

        $user->save();

        // Redirect or return a response

        return redirect()->back()->with('success', 'User updated successfully!');

    }



    //-----------------------------------------END COMPANY INFO SETTING



    



    //-----------------------------------------GENERAL SETTING



    //-----------------------------------------UOM SECTION-----------------------------------------

    //GET UOM

    public function uom(Request $request){

        $uom = UOM::all();

        return view('setting.uom', compact('uom'));

    }

    //CREATE NEW SIZE

    public function createUOM(Request $request)

    {

        $validatedData = $request->validate([

            'UOM_name' => 'required|string|max:255',

            'UOM_abb' => 'required|string|max:255',

        ]);

        UOM::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'UOM added successfully!');

    }

    //UPDATE EXISTING UOM

    public function UOMupdate(Request $request,$UOM_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'UOM_name' => 'required|string|max:255',

            'UOM_abb' => 'required|string|max:255',

        ], [

            'UOM_name.required' => 'Please input UOM Name',

            'UOM_abb.required' => 'Please input UOM Abbreviation',

        ]);

        // Find the UOM by ID

        $UOM_id = UOM::find($UOM_id);

        // Update the UOM data

        $UOM_id->UOM_name = $validatedData['UOM_name'];

        $UOM_id->UOM_abb = $validatedData['UOM_abb'];

        // Save the changes

        $UOM_id->save();

        return redirect('/uom')->with('success', 'UOM Updated Successfully');

    }

    //DELETE EXISTING UOM

    public function UOMdestroy($UOM_id)

    {

        UOM::destroy($UOM_id);

        return redirect('uom')->with('success', 'UOM Was deleted!');

    }

    //UOM TOGGLE STATUS

    public function UOMtoggleStatus(Request $request, $id)

    {

        $uom = UOM::find($id);

        if (!$uom) {

            return response()->json(['success' => false, 'message' => 'UOM not found'], 404);

        }

        $newStatus = $request->input('status');

        $uom->status = $newStatus;

        $uom->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    



    //-----------------------------------------CURRENCY SECTION-----------------------------------------

    //GET CURRENCY

    public function currency(Request $request){

        $currency = Currency::all();

        return view('setting.currency', compact('currency'));

    }

    //CREATE NEW CURRENCY

    public function createCurrency(Request $request){

        $validatedData = $request->validate([

            'Currency_name' => 'required|string|max:255',

            'Currency_alias' => 'required|string|max:255',

        ]);

        Currency::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Currency added successfully!');

    }

    //UPDATE EXISTING CURRENCY

    public function Currencyupdate(Request $request,$Currency_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'Currency_name' => 'required|string|max:255',

            'Currency_alias' => 'required|string|max:255',

        ], [

            'Currency_name.required' => 'Please input Currency Name',

            'Currency_alias.required' => 'Please input Currency Alias',

        ]);

        // Find the Add-on by ID

        $Currency_id = Currency::find($Currency_id);

        // Update the Add-on data

        $Currency_id->Currency_name = $validatedData['Currency_name'];

        $Currency_id->Currency_alias = $validatedData['Currency_alias'];

        // Save the changes

        $Currency_id->save();

        return redirect('/currency')->with('success', 'Currency Updated Successfully');

    }

    //DELETE EXISTING CURRENCY

    public function Currencydestroy($Currency_id)

    {

        Currency::destroy($Currency_id);

        return redirect('currency')->with('success', 'Currency Was Deleted!');

    }

    //CURRENCY TOGGLE STATUS

    public function CurrencytoggleStatus(Request $request, $id)

    {

        $currency = Currency::find($id);

        if (!$currency) {

            return response()->json(['success' => false, 'message' => 'Currency not found'], 404);

        }

        $newStatus = $request->input('status');

        $currency->status = $newStatus;

        $currency->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END CURRENCY SECTION-----------------------------------------



    //-----------------------------------------PAYMENT METHOD SECTION-----------------------------------------

    //GET PAYMENT METHOD

    public function payment (Request $request){

        $payment = PaymentMethod::all();

        $paymentCate = PaymentCate::all();

        return view('setting.payment-method', compact('payment', 'paymentCate'));

    }

    //CREATE NEW PAYMENT METHOD

    public function createPayment(Request $request)

    {

        $validatedData = $request->validate([

            'IPM_fullname' => 'required|string|max:255',

            'IPM_alias' => 'required|string|max:255',

            'PMCate_id' => 'required|integer',

        ]);

        PaymentMethod::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Payment Method was created successfully!');

    }

    //UPDATE EXISTING PAYMENT METHOD

    public function Paymentupdate(Request $request,$IPM_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'IPM_fullname' => 'required|string|max:255',

            'IPM_alias' => 'required|string|max:255',

            'PMCate_id' => 'required|integer',

        ], [

            'IPM_fullname.required' => 'Payment Method Full Name Should Be Provided',

            'IPM_alias.required' => 'Payment Method Full Name Should Be Provided',

            'PMCate_id.required' => 'Help provide category for your payment method',

        ]);

        // Find the Menu Group by ID

        $IPM_id = invMenuCate::find($IPM_id);

        // Update the Manu Group data

        $IPM_id->IPM_fullname = $validatedData['IPM_fullname'];

        $IPM_id->IPM_alias = $validatedData['IPM_alias'];

        $IPM_id->PMCate_id = $validatedData['PMCate_id'];

        // Save the changes

        $IPM_id->save();

        return redirect('/payment')->with('success', 'Payment Method Was Updated Successfully');

    }

    //DELETE EXISTING PAYMENT METHOD

    public function Paymentdestroy($IPM_id)

    {

        PaymentMethod::destroy($IPM_id);

        return redirect('payment_method')->with('success', 'Payment Method Was Deleted!');

    }

    //PAYMENT METHOD TOGGLE STATUS

    public function PaymenttoggleStatus(Request $request, $id)

    {

        $payment = PaymentMethod::find($id);

        if (!$payment) {

            return response()->json(['success' => false, 'message' => 'Payment Method Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $payment->status = $newStatus;

        $payment->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END PAYMENT METHOD SECTION-----------------------------------------



    //-----------------------------------------PAYMENT METHOD SECTION-----------------------------------------

    //GET PAYMENT METHOD CATEGORY

    public function paymentCate (Request $request){

        $paymentCate = PaymentCate::all();

        return view('setting.payment_category', compact('paymentCate'));

    }

    //CREATE NEW PAYMENT METHOD CATEGORY

    public function createPaymentCate(Request $request)

    {

        $validatedData = $request->validate([

            'PMCate_Khname' => 'required|string|max:255',

            'PMCate_Engname' => 'required|string|max:255',

        ]);

        PaymentCate::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Payment Method Category was created successfully!');

    }

    //UPDATE EXISTING PAYMENT METHOD CATEGORY

    public function PaymentCateupdate(Request $request,$PMCate_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'PMCate_Khname' => 'required|string|max:255',

            'PMCate_Engname' => 'required|string|max:255',

        ], [

            'PMCate_Khname.required' => 'Payment Method Category Name Should Be Provided',

            'PMCate_Engname.required' => 'Payment Method Category Name Should Be Provided',

        ]);

        // Find the Payment Method Category by ID

        $PMCate_id = PaymentCate::find($PMCate_id);

        // Update the Payment Method Category data

        $PMCate_id->PMCate_Khname = $validatedData['PMCate_Khname'];

        $PMCate_id->PMCate_Engname = $validatedData['PMCate_Engname'];

        // Save the changes

        $PMCate_id->save();

        return redirect('/payment_category')->with('success', 'Payment Method Category Was Updated Successfully');

    }

    //DELETE EXISTING PAYMENT METHOD CATEGORY

    public function PaymentCatedestroy($PMCate_id)

    {

        PaymentCate::destroy($PMCate_id);

        return redirect('payment_category')->with('success', 'Payment Method Category Was Deleted!');

    }

    //PAYMENT METHOD CATEGORY TOGGLE STATUS

    public function PaymentCatetoggleStatus(Request $request, $id)

    {

        $paymentCate = PaymentCate::find($id);

        if (!$paymentCate) {

            return response()->json(['success' => false, 'message' => 'Payment Method Category Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $paymentCate->status = $newStatus;

        $paymentCate->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    



    //-----------------------------------------END PAYMENT METHOD CATEGORY SECTION-----------------------------------------



    //-----------------------------------------SIZE SECTION-----------------------------------------

    //GET SIZE

    public function size (Request $request)

    {

        $size = invSize::all();

        return view('setting.size', compact('size'));

    }

     //CREATE NEW SIZE

    public function createSize(Request $request)

    {

        $validatedData = $request->validate([

            'Size_name' => 'required|string|max:255',

            'Size_abb' => 'required|string|max:255',

        ]);

        invSize::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Size added successfully!');

    }

    //UPDATE EXISTING SIZE

    public function Sizeupdate(Request $request,$Size_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'Size_name' => 'required|string|max:255',

            'Size_abb' => 'required|string|max:255',

        ], [

            'Size_name.required' => 'Please input Size Name',

            'Size_abb.required' => 'Please input Size Abbreviation',

        ]);

        // Find the Size by ID

        $Size_id = invSize::find($Size_id);

        // Update the Add-on data

        $Size_id->Size_name = $validatedData['Size_name'];

        $Size_id->Size_abb = $validatedData['Size_abb'];

        // Save the changes

        $Size_id->save();

        return redirect('/size')->with('success', 'Size Updated Successfully');

    }

    //DELETE EXISTING SIZE

    public function Sizedestroy($Size_id)

    {

        invSize::destroy($Size_id);

        return redirect('size')->with('success', 'Size Was Deleted!');

    }

    //SIZE TOGGLE STATUS

    public function SizetoggleStatus(Request $request, $id)

    {

        $size = invSize::find($id);

        if (!$size) {

            return response()->json(['success' => false, 'message' => 'Size not found'], 404);

        }

        $newStatus = $request->input('status');

        $size->status = $newStatus;

        $size->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END SIZE SECTION-----------------------------------------



    



    //-----------------------------------------END GENERAL SETTING



    



    



    //-----------------------------------------OWNER SECTION-----------------------------------------



    public function owner (Request $request){

        $invOwners = InvOwner::all();

        return view('setting.owner', compact('invOwners'));

    }



    //-----------------------------------------END OWNER SECTION-----------------------------------------



    



    //-----------------------------------------ROLE SECTION-----------------------------------------

    //GET ROLE INFORMATION

    public function role(){

        $roles = InvRole::all();

        return view('setting.role', compact('roles'));

    }

    //CREATE NEW ROLE

    public function createRole(Request $request){

        $validatedData = $request->validate([

            'R_type' => 'required|string|max:255',

        ]);

        InvRole::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Role added successfully!');

    }

    //UPDATE EXISTING ROLE

    public function Roleupdate(Request $request,$R_id)

    {



           // Validate the request data



           $validatedData = $request->validate([



            'R_type' => 'required|string|max:255',



        ], [



            'R_type.required' => 'Please input Role Type',



        ]);



    



        // Find the Role by ID



        $R_id = InvRole::find($R_id);



 



        // Update the Role data



        $R_id->R_type = $validatedData['R_type'];



    



        // Save the changes



        $R_id->save();



    



        return redirect('/role')->with('success', 'Role Updated Successfully');



    }

    //DELETE EXISTING ROLE

    public function Roledestroy($R_id)

    {

        InvRole::destroy($R_id);

        return redirect('role')->with('success', 'Role deleted!');

    }

    //ROLE TOGGLE STATUS

    public function RoletoggleStatus(Request $request, $id)

    {

        $role = InvRole::find($id);

        if (!$role) {

            return response()->json(['success' => false, 'message' => 'Role not found'], 404);

        }

        $newStatus = $request->input('status');

        $role->status = $newStatus;

        $role->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END ROLE SECTION-----------------------------------------



    //-----------------------------------------POSITION SECTION-----------------------------------------

    //GET POSITION INFORMATION

    public function position(){

        $position = Position::all();

        return view('setting.position', compact('position'));

    }

    //CREATE NEW POSITION

    public function createPosition(Request $request){

        $validatedData = $request->validate([

            'position_name' => 'required|string|max:255',

            'position_alias' => 'required|string|max:255',

        ]);

        Position::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Position Was Added Successfully!');

    }

    //UPDATE EXISTING POSITION

    public function updatePosition(Request $request,$position_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'position_name' => 'required|string|max:255',

            'position_alias' => 'required|string|max:255',

        ], [

            'position_name.required' => 'Please input name',

        ]);

        // Find the Position by ID

        $position_id = Position::find($position_id);

        // Update the Position data

        $position_id->position_name = $validatedData['position_name'];

        $position_id->position_alias = $validatedData['position_alias'];

        // Save the changes

        $position_id->save();

        return redirect('/position')->with('success', 'Position Was Updated Successfully');

    }

    //DELETE EXISTING POSITION

    public function destroyPosition($position_id)

    {

        Position::destroy($position_id);

        return redirect('position')->with('success', 'Position deleted!');

    }

    //POSITION TOGGLE STATUS

    public function PositiontoggleStatus(Request $request, $id)

    {

        $position = Position::find($id);

        if (!$position) {

            return response()->json(['success' => false, 'message' => 'Position not found'], 404);

        }

        $newStatus = $request->input('status');

        $position->status = $newStatus;

        $position->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END POSITION SECTION-----------------------------------------



    //-----------------------------------------MENU SETTING



    //-----------------------------------------MENU GROUP SECTION-----------------------------------------

    //GET MENU GROUP

    public function menu_group (Request $request){

        $groups = MenuGroup::all();

        return view('setting.menu-group', compact('groups'));

    }

    //CREATE NEW MENU GROUP

    public function createMenuGr(Request $request){

        $validatedData = $request->validate([

            'MenuGr_Khname' => 'required|string|max:255',

            'MenuGr_Engname' => 'required|string|max:255',

        ]);

        MenuGroup::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Menu Group added successfully!');

    }

    //UPDATE EXISTING MENU GROUP

    public function MenuGrupdate(Request $request,$MenuGr_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'MenuGr_Khname' => 'required|string|max:255',

            'MenuGr_Engname' => 'required|string|max:255',

        ], [

            'MenuGr_Khname.required' => 'Please input Menu Group Khmer Name',

            'MenuGr_Engname.required' => 'Please input Menu Group English Name',

        ]);

        // Find the Menu Group by ID

        $MenuGr_id = MenuGroup::find($MenuGr_id);

        // Update the Manu Group data

        $MenuGr_id->MenuGr_Khname = $validatedData['MenuGr_Khname'];

        $MenuGr_id->MenuGr_Engname = $validatedData['MenuGr_Engname'];

        // Save the changes

        $MenuGr_id->save();

        return redirect('/menu_group')->with('success', 'Menu Group Updated Successfully');

    }

    //DELETE EXISTING MENU GROUP

    public function MenuGrdestroy($MenuGr_id)

    {

        MenuGroup::destroy($MenuGr_id);

        return redirect('menu_group')->with('success', 'Menu Group deleted!');

    }

    //MENU GROUP TOGGLE STATUS

    public function MenuGrtoggleStatus(Request $request, $id)

    {

        $MenuGr = MenuGroup::find($id);

        if (!$MenuGr) {

            return response()->json(['success' => false, 'message' => 'Menu Group not found'], 404);

        }

        $newStatus = $request->input('status');

        $MenuGr->status = $newStatus;

        $MenuGr->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END MENU GROUP SECTION-----------------------------------------



    //-----------------------------------------MENU CATEGORY SECTION-----------------------------------------

    //GET MENU CATEGORY

    public function menuCat(Request $request){

        $group = MenuGroup::all();

        $menu_category = invMenuCate::all();

        return view('setting.menuCat', compact('menu_category', 'group'));

    }

    //CREATE NEW MENU CATEGORY

    public function createMenuCate(Request $request){

        $validatedData = $request->validate([

            'Cate_Khname' => 'required|string|max:255',

            'Cate_Engname' => 'required|string|max:255',

            'MenuGr_id' => 'required|integer',

        ]);

        invMenuCate::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Menu Category added successfully!');

    }

    //UPDATE EXISTING MENU CATEGORY

    public function MenuCateupdate(Request $request,$Menu_Cate_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'Cate_Khname' => 'required|string|max:255',

            'Cate_Engname' => 'required|string|max:255',

            'MenuGr_id' => 'required|integer',

        ], [

            'Cate_Khname.required' => 'Please input Menu Category Khmer Name',

            'Cate_Engname.required' => 'Please input Menu Category English Name',

            'MenuGr_id.required' => 'Please input Menu Group',

        ]);

        // Find the Menu Group by ID

        $Menu_Cate_id = invMenuCate::find($Menu_Cate_id);

        // Update the Manu Group data

        $Menu_Cate_id->Cate_Khname = $validatedData['Cate_Khname'];

        $Menu_Cate_id->Cate_Engname = $validatedData['Cate_Engname'];

        $Menu_Cate_id->MenuGr_id = $validatedData['MenuGr_id'];

        // Save the changes

        $Menu_Cate_id->save();

        return redirect('/menu_category')->with('success', 'Menu Category Updated Successfully');

    }



    //DELETE EXISTING MENU CATEGORY

    public function MenuCatedestroy($Menu_Cate_id)

    {

        invMenuCate::destroy($Menu_Cate_id);

        return redirect('menu_category')->with('success', 'Menu Category deleted!');

    }

    //MENU CATEGORY TOGGLE STATUS

    public function MenuCatetoggleStatus(Request $request, $id)

    {

        $MenuCate = invMenuCate::find($id);

        if (!$MenuCate) {

            return response()->json(['success' => false, 'message' => 'Menu Category not found'], 404);

        }

        $newStatus = $request->input('status');

        $MenuCate->status = $newStatus;

        $MenuCate->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END MENU CATEGORY SECTION-----------------------------------------



    //-----------------------------------------INGREDIENTS SECTION-----------------------------------------

    //GET INGREDIENT INFORMATION

    public function ingredient ()

    {

        $dropdownMenu = Menu::all();

        $menuIngredients = MenuIngredients::all()->groupBy('Menu_id');

        $invMenu = Menu::paginate(12);

        $material = Material::all();

        $uom = UOM::all();

        $ingredientQty = IngredientQty::all();

        return view('setting.menu', compact('menuIngredients', 'invMenu', 'material', 'uom', 'ingredientQty', 'dropdownMenu'));

    }

    //CREATE NEW INGREDIENTS

    public function createIng(Request $request){

        $validatedData = $request->validate([

            'Qty' => 'required|integer',

            'Material_id' => 'required|integer',

            'UOM_id' =>'required|integer',

            'IIQ_name' => ['required', 'string', 'max:255'],

        ]);        

        // Create the item category record in the database

        IngredientQty::create([

            'Qty' => $validatedData['Qty'],

            'Material_id' =>  $validatedData['Material_id'], 

            'UOM_id' => $validatedData['UOM_id'],

            'IIQ_name' =>  $validatedData['IIQ_name'], 

            'status' => 'Active',

        ]);   

        // Redirect or return a response

        return redirect()->back()->with('success', 'Category created successfully!');

    }

    //ADD NEW INGREDIENT

    public function addIng(Request $request){

        $validatedData = $request->validate([

            'Menu_id' => 'required|integer',

            'IIQ_id' => 'required|integer',

        ]);        

        // Create the item category record in the database

        IngredientRe::create([

            'Menu_id' => $validatedData['Menu_id'],

            'IIQ_id' =>  $validatedData['IIQ_id'], 

        ]);   

        // Redirect or return a response

        return redirect()->back()->with('success', 'Ingredient created successfully!');

    }

    //UPDATE EXISTING INGREDIENT

    public function updateIngredients(Request $request, $IPI_id)

    {

        // Validate the input data

        $validatedData = $request->validate([

            'IIQ_id' => 'required|array',

            'IIQ_id.*' => 'required|integer', 

        ]);

        // Find all products by Pro_id

        $menu = IngredientRe::where('Menu_id', $request->Menu_id)->get();

        // Check if any products exist

        if ($menu->isEmpty()) {

            return redirect()->back()->with('error', 'No menu found with this ID.');

        }

        // Loop through each IIQ_id and update the corresponding products

        foreach ($menu as $key => $product) {

            // Check if the key exists in the IIQ_id array to avoid errors

            if (isset($validatedData['IIQ_id'][$key])) {

                $product->IIQ_id = $validatedData['IIQ_id'][$key];

                $product->save();

            }

        }

        return redirect()->back()->with('success', 'Menu updated successfully!');

    }

    //Operation on Menu Ingredient

    public function IngredientOperation (Request $request){

        $menuIngredients = MenuIngredients::all()->groupBy('Menu_id');

        $invMenu = Menu::paginate(12);

        $material = Material::all();

        $uom = UOM::all();

        $ingredientQty = IngredientQty::all();

        return view('setting.menu', compact('menuIngredients', 'invMenu', 'material', 'uom', 'ingredientQty'));

    }

    //SEARCH INGREDIENT

    public function Ingredientsearch(Request $request)

    {

        $material = Material::all();

        $searchQuery = $request->input('search');

        $menuIngredients = MenuIngredients::where('Menu_ENGName', 'LIKE', '%' . $searchQuery . '%')

            ->orWhereHas('material', function($query) use ($searchQuery) {

                $query->where('Material_ENGName', 'LIKE', '%' . $searchQuery . '%');

            })

            ->get()

            ->groupBy('Menu_id');

        return response()->json(['ingredient' => $menuIngredients]);

    }

    //INGREDIENT TOGGLE STATUS

    public function IngredienttoggleStatus(Request $request, $id)

    {

        $material = Menu::find($id);

        if (!$material) {

            return response()->json(['success' => false, 'message' => 'Ingredient not found'], 404);

        }

        $newStatus = $request->input('status');

        $material->status = $newStatus;

        $material->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END INGREDIENTS SECTION-----------------------------------------



    //-----------------------------------------ADD-ON SECTION-----------------------------------------

    //GET ADD-ON

    public function addon (){

        $uom =UOM::all();

        $Addons = Addon::with('uom')->paginate(8); 

        return view('setting.add-on', compact('Addons','uom'));

    }

    //CREATE NEW ADD-ON

    public function createAddon(Request $request)

    {

        $validatedData = $request->validate([

            'Addons_name' => 'required|string|max:255',

            'Percentage' => 'required|string|max:255',

            'Qty' => 'required|integer',

            'UOM_id' => 'required|integer',

        ]);

        Addon::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Product added successfully!');

    }

    //UPDATE EXISTING ADD-ON

    public function Addonupdate(Request $request,$Addons_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'Addons_name' => 'required|string|max:255',

            'Percentage' => 'required|string|max:255',

            'Qty' => 'required|integer',

            'UOM_id' => 'required|integer',

        ], [

            'Addons_name.required' => 'Please input Add-on Name',

            'Percentage.required' => 'Please input Add-on Percentage',

            'Qty.required' => 'Please input Add-on Qty',

            'UOM_id.required' => 'Please input Unit of Measure',

        ]);

        // Find the Add-on by ID

        $addons = Addon::find($Addons_id);

        // Update the Add-on data

        $addons->Addons_name = $validatedData['Addons_name'];

        $addons->Percentage = $validatedData['Percentage'];

        $addons->Qty = $validatedData['Qty'];

        $addons->UOM_id = $validatedData['UOM_id'];

        // Save the changes

        $addons->save();

        return redirect('/add-on')->with('success', 'Add-on Updated Successfully');

    }

    //DELETE EXISTING ADD-ON

    public function Addondestroy($Addons_id)

    {

        Addon::destroy($Addons_id);

        return redirect('add-on')->with('success', 'Addon deleted!');

    }

    //SEARCH ADD-ON

    public function Addonsearch(Request $request)

    {

        $searchTerm = $request->input('search');

        $suppliers = Addon::where('Addons_name', 'LIKE', "%{$searchTerm}%")->paginate(8); 

        $output = '';

        foreach ($suppliers as $index => $data) {

            $rowClass = ($index % 2 === 0) ? 'bg-zinc-200' : 'bg-zinc-300';

            $borderClass = ($index === 0) ? 'border-t-4' : '';

            $output .= '

            <tr class="' . $rowClass . ' text-base ' . $borderClass . ' text-center border-white">

            <td class="py-3 px-4 border border-white">' . ($data->Addons_id ?? 'null') . '</td>

            <td class="py-3 px-4 border border-white">' . ($data->Addons_name ?? 'null') . '</td>

            <td class="py-3 px-4 border border-white">' . ($data->Percentage ?? 'null') . '</td>

            <td class="py-3 px-4 border border-white">' . ($data->Qty ?? 'null' ) . '</td>

            <td class="py-3 px-4 border border-white">' . ( $data->uom->UOM_name ?? 'null') . '</td>

            <td class="py-3 border border-white">

                <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group" onclick="openEditPopup(' . $data->Sup_id . ', \'' . $data->Sup_name . '\', \'' . $data->Sup_contact . '\', \'' . $data->Sup_address . '\')">

                <i class="fas fa-edit fa-xs"></i>

                <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Edit</span>

                </button>

                <button class="relative bg-red-500 hover:bg-red-600 active:bg-red-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group" 

                        onclick="if(confirm(\'Are you sure you want to delete?\')) window.location.href=\'add-ons/destroy/' . $data->Addons_id . '\';">

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

    //ADD-ON TOGGLE STATUS

    public function AddontoggleStatus(Request $request, $id)

    {

        $material = Addon::find($id);

        if (!$material) {

            return response()->json(['success' => false, 'message' => 'Material not found'], 404);

        }

        $newStatus = $request->input('status');

        $material->status = $newStatus;

        $material->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END ADD-ON SECTION-----------------------------------------



    



    //-----------------------------------------END MENU SETTING







    



    //-----------------------------------------MATERIAL SETTING



    



    //-----------------------------------------END MATERIAL GROUP SECTION-----------------------------------------

    //GET MATERIAL GROUP

    public function material_group (Request $request){

        $materialGroup = MaterialGroup::all();

        return view('setting.material-group', compact('materialGroup'));

    }

    //CREATE NEW MATERIAL GROUP

    public function createMaterialGr(Request $request)

    {

        $validatedData = $request->validate([

            'IMG_khname' => 'required|string|max:255',

            'IMG_engname' => 'required|string|max:255',

        ]);

        MaterialGroup::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Material Group created successfully!');

    }

    //UPDATE EXISTING MATERIAL GROUP

    public function MaterialGrupdate(Request $request,$IMG_id)

    {

        //Validate the request data

        $validatedData = $request->validate([

            'IMG_khname' => 'required|string|max:255',

            'IMG_engname' => 'required|string|max:255',

        ], [

            'IMG_khname.required' => 'Please input Material Group Khmer Name',

            'IMG_engname.required' => 'Please input Material Group English Name',

        ]);

        //Find the Material Group by ID

        $IMG_id = MaterialGroup::find($IMG_id);

        //Update the Material Group by data

        $IMG_id->IMG_khname = $validatedData['IMG_khname'];

        $IMG_id->IMG_engname = $validatedData['IMG_engname'];

        //Save the changes

        $IMG_id->save();

        return redirect('/material_group')->with('success', 'Material Group Updated Successfully');

    }

    //DELETE EXISTING MATERIAL GROUP

    public function MaterialGrdestroy($IMG_id)

    {

        MaterialGroup::destroy($IMG_id);

        return redirect('material_group')->with('success', 'Material Group deleted!');

    }

    //MATERIAL GROUP TOGGLE STATUS

    public function MaterialGrtoggleStatus(Request $request, $id)

    {

        $materialGr = MaterialGroup::find($id);

        if (!$materialGr) {

            return response()->json(['success' => false, 'message' => 'Material Group not found'], 404);

        }

        $newStatus = $request->input('status');

        $materialGr->status = $newStatus;

        $materialGr->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END MATERIAL GROUP SECTION-----------------------------------------



    //-----------------------------------------MATERIAL CATEGORY SECTION-----------------------------------------

    //MATERIAL CATEGORY

    public function materialCat (Request $request){

        $group = MaterialGroup::all();

        $materialcat = MaterialCategory::all();

        return view('setting.materialCat', compact('materialcat', 'group'));

    }

    //CREATE NEW MATERIAL CATEGORY

    public function createMaterialCate(Request $request)

    {

        $validatedData = $request->validate([

            'Material_Cate_Khname' => 'required|string|max:255',

            'Material_Cate_Engname' => 'required|string|max:255',

            'IMG_id' =>'required|integer',

        ]);

        MaterialCategory::create($validatedData);

        // Redirect or return response

        return redirect()->back()->with('success', 'Material Category created successfully!');

    }

    //UPDATE EXISTING MATERIAL CATEGORY

    public function MaterialCateupdate(Request $request,$Material_Cate_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'Material_Cate_Khname' => 'required|string|max:255',

            'Material_Cate_Engname' => 'required|string|max:255',

            'IMG_id' =>'required|integer',

        ], [

            'Material_Cate_Khname.required' => 'Please input Material Category Khmer Name',

            'Material_Cate_Engname.required' => 'Please input Material Category English Name',

            'IMG_id' => 'Please input Material Group',

        ]);

        // Find the Material Category by ID

        $materilCate = MaterialCategory::find($Material_Cate_id);

        // Update the Material Category by data

        $materilCate->Material_Cate_Khname = $validatedData['Material_Cate_Khname'];

        $materilCate->Material_Cate_Engname = $validatedData['Material_Cate_Engname'];

        $materilCate->IMG_id = $validatedData['IMG_id'];

        // Save the changes

        $materilCate->save();

        return redirect('/material_category')->with('success', 'Material Category Updated Successfully');

    }

    //DELETE EXISTING MATERIAL CATEGORY

    public function MaterialCatedestroy($Material_Cate_id)

    {

        MaterialCategory::destroy($Material_Cate_id);

        return redirect('material_category')->with('success', 'Material Category deleted!');

    }

    //MATERIAL CATEGORY TOGGLE STATUS

    public function MaterialCatetoggleStatus(Request $request, $id)

    {

        $materialCate = MaterialCategory::find($id);

        if (!$materialCate) {

            return response()->json(['success' => false, 'message' => 'Material Category not found'], 404);

        }

        $newStatus = $request->input('status');

        $materialCate->status = $newStatus;

        $materialCate->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }



    //-----------------------------------------END MATERIAL CATEGORY SECTION-----------------------------------------



    



    //-----------------------------------------END MATERIAL SETTING



    



    //-----------------------------------------PROFIT / LOSE INFO SETTING



    //-----------------------------------------EXPENSE CATEGORY SECTION-----------------------------------------

    //GET EXPENSE CATEGORY

    public function expenseCat (Request $request){

        $expenseCat = ExpenseCate::all();

        return view('setting.expenseCat', compact('expenseCat'));

    }

    //CREATE NEW EXPENSE CATEGORY

    public function createExpenseCate(Request $request){

        $validatedData = $request->validate([

            'IEC_Khname' => ['required', 'string', 'max:255'],

            'IEC_Engname' => ['required', 'string', 'max:255'], // Add validation rule for English name

        ]);

        // Create the expense category record in the database

        ExpenseCate::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Expense Category created successfully!');

    }

    //UPDATE EXISTING EXPENSE CATEGORY

    public function ExpenseCateupdate(Request $request,$IEC_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'IEC_Khname' => ['required', 'string', 'max:255'],

            'IEC_Engname' => ['required', 'string', 'max:255'], // Add validation rule for English name

        ], [

            'IEC_Khname.required' => 'Please input Expense Category Khmer Name',

            'IEC_Engname.required' => 'Please input Expense Category English Name',

        ]);

        // Find the Material Category by ID

        $expenseCate = ExpenseCate::find($IEC_id);

        // Update the Material Category by data

        $expenseCate->IEC_Khname = $validatedData['IEC_Khname'];

        $expenseCate->IEC_Engname = $validatedData['IEC_Engname'];

        // Save the changes

        $expenseCate->save();

        return redirect('/expense_category')->with('success', 'Expense Category Updated Successfully');

    }

    //DELETE EXISTING EXPENSE CATEGORY

    public function ExpenseCatedestroy($IEC_id)

    {

        ExpenseCate::destroy($IEC_id);

        return redirect('expense_category')->with('success', 'Expense Category deleted!');

    }

    //EXPENSE CATEGORY TOGGLE STATUS

    public function ExpenseCatetoggleStatus(Request $request, $id)

    {

        $expenseCate = ExpenseCate::find($id);

        if (!$expenseCate) {

            return response()->json(['success' => false, 'message' => 'Expense Category not found'], 404);

        }

        $newStatus = $request->input('status');

        $expenseCate->status = $newStatus;

        $expenseCate->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END EXPENSE CATEGORY SECTION-----------------------------------------

    //-----------------------------------------INCOME CATEGORY SECTION-----------------------------------------

    //GET INCOME CATEGORY

    public function incomeCate (Request $request){

        $incomeCate = IncomeCate::all();

        return view('setting.incomeCate', compact('incomeCate'));

    }

    //CREATE NEW INCOME CATEGORY

    public function createIncomeCate(Request $request){

        $validatedData = $request->validate([

            'IC_Khname' => ['required', 'string', 'max:255'],

            'IC_Engname' => ['required', 'string', 'max:255'], // Add validation rule for English name

        ]);

        // Create the income category record in the database

        IncomeCate::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Income Category created successfully!');

    }

    //UPDATE EXISTING INCOME CATEGORY

    public function IncomeCateupdate(Request $request,$IC_id)

    {

           // Validate the request data

        $validatedData = $request->validate([

            'IC_Khname' => ['required', 'string', 'max:255'],

            'IC_Engname' => ['required', 'string', 'max:255'], // Add validation rule for English name

        ], [

            'IC_Khname.required' => 'Please input Income Category Khmer Name',

            'IC_Engname.required' => 'Please input Income Category English Name',

        ]);

        // Find the Income Category by ID

        $incomeCate = IncomeCate::find($IC_id);

        // Update the Income Category by data

        $incomeCate->IC_Khname = $validatedData['IC_Khname'];

        $incomeCate->IC_Engname = $validatedData['IC_Engname'];

        // Save the changes

        $incomeCate->save();

        return redirect('/income_category')->with('success', 'Income Category Updated Successfully');

    }

    //DELETE EXISTING INCOME CATEGORY

    public function IncomeCatedestroy($IC_id)

    {

        IncomeCate::destroy($IC_id);

        return redirect('income_category')->with('success', 'Income Category deleted!');

    }

    //INCOME CATEGORY TOGGLE STATUS

    public function IncomeCatetoggleStatus(Request $request, $id)

    {

        $incomeCate = IncomeCate::find($id);

        if (!$incomeCate) {

            return response()->json(['success' => false, 'message' => 'Income Category not found'], 404);

        }

        $newStatus = $request->input('status');

        $incomeCate->status = $newStatus;

        $incomeCate->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END INCOME CATEGORY SECTION-----------------------------------------



    //-----------------------------------------END PROFIT / LOSE INFO SETTING





    //-----------------------------------------POS SETTING



    //-----------------------------------------TABLE SECTION-----------------------------------------

    //GET TABLE INFORMATION

    public function getTable (Request $request){

        $getTable = Table::all();

        return view('setting.table', compact('getTable'));

    }

    //CREATE NEW TABLE

    public function createTable(Request $request){

        $validatedData = $request->validate([

            'table_name' => ['required', 'string', 'max:255'],

            'table_location' => ['required', 'string', 'max:255'],

            'table_number' => ['required', 'integer'],

        ]);

        // Create the Table record in the database

        Table::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Table Was Created Successfully!');



    }

    //UPDATE EXISTING TABLE

    public function updateTable(Request $request,$pos_table_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'table_name' => ['required', 'string', 'max:255'],

            'table_location' => ['required', 'string', 'max:255'],

            'table_number' => ['required', 'integer'],

        ], [

            'table_name.required' => 'Please input Table Name',

            'table_number.required' => 'Please input Table Number',

            'table_location.required' => 'Please input Table Location',

        ]);

        // Find the Table by ID

        $table = Table::find($pos_table_id);

        // Update the Table by data

        $table->table_name = $validatedData['table_name'];

        $table->table_number = $validatedData['table_number'];

        $table->table_location = $validatedData['table_location'];

        // Save the changes

        $table->save();

        return redirect('/table_setting')->with('success', 'Table Was Updated Successfully');

    }

    //DELETE EXISTING TABLE

    public function deleteTable($pos_table_id)

    {

        Table::destroy($pos_table_id);

        return redirect('table_setting')->with('success', 'Table Was Deleted!');

    }

    //CHANGE TABLE STATUS

    public function TabletoggleStatus(Request $request, $id)

    {

        $table = Table::find($id);

        if (!$table) {

            return response()->json(['success' => false, 'message' => 'Table Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $table->status = $newStatus;

        $table->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END TABLE SECTION-----------------------------------------

    //-----------------------------------------MENU DETAIL SECTION-----------------------------------------

    //GET MENU DETAIL INFORMATION

    public function getMenuDetail (Request $request){

        $menu = Menu::all();

        $size = invSize::all();

        $currency = Currency::all();

        $menuDetail = MenuDetail::all()->groupBy('Menu_id');

        $getMenuDetail = MenuDetail::paginate(4);

        return view('setting.menu-detail', compact('getMenuDetail', 'menu', 'size', 'currency', 'menuDetail'));

    }

    //CREATE NEW MENU DETAIL

    public function mapMenuDetail(Request $request){

        $validatedData = $request->validate([
            'Menu_id' => ['required', 'integer'],
            'Size_id' => ['required', 'integer'],
            'price' => ['required', 'numeric', 'between:0,99.99'],
            'Currency_id' => ['required', 'integer'],
        ]);
        $checkExisting = MenuDetail::where('Menu_id', $validatedData['Menu_id'])
        ->where('Size_id', $validatedData['Size_id'])
        ->first();
    if($checkExisting){
        return redirect()->back()->with('error', 'Menu Detail With This Size already exists!');
    }  else {
        MenuDetail::create($validatedData);
        return redirect()->back()->with('success', 'Menu Detail Was Created Successfully!');
    }

    }

    //ADD MENU DETAIL

    public function addMenuDetail(Request $request){
        $validatedData = $request->validate([
            'Menu_id' => ['required', 'integer'],
            'Size_id' => ['required', 'integer'],
            'price' => ['required', 'numeric', 'between:0,99.99'],
            'Currency_id' => ['required', 'integer'],
        ]);
        $checkExisting = MenuDetail::where('Menu_id', $validatedData['Menu_id'])
            ->where('Size_id', $validatedData['Size_id'])
            ->first();
        if($checkExisting){
            return redirect()->back()->with('error', 'Menu Detail With This Size already exists!');
        }  else {
            MenuDetail::create($validatedData);
            return redirect()->back()->with('success', 'Menu Detail Was Added Successfully!');
        }
    }

    //UPDATE EXISTING MENU DETAIL

    public function updateMenuDetail(Request $request,$pos_menu_detail_id)
    {
        //dd($request->all());
        // Validate the request data
        $validatedData = $request->validate([
            'Menu_id' => ['required', 'integer'],
            'Size_id' => ['required', 'integer'],
            'price' => ['required', 'numeric', 'between:0,99.99'],
            'Currency_id' => ['required', 'integer'],
        ], [
            'Menu_id.required' => 'Please Select Menu Name',
            'Size_id.required' => 'Please Select Size Name',
            'price.required' => 'Please provide the price',
            'Currency_id.required' => 'Please Select Currency Name',
        ]);
        // Find the Menu Detail by ID
        $menuDetail = MenuDetail::find($pos_menu_detail_id);
        // Update the Menu Detail Table by data
        $menuDetail->Menu_id = $validatedData['Menu_id'];
        $menuDetail->Size_id = $validatedData['Size_id'];
        $menuDetail->price = $validatedData['price'];
        $menuDetail->Currency_id = $validatedData['Currency_id'];
        // Save the changes
        $menuDetail->save();
        return redirect('/menu_detail')->with('success', 'Menu Detail Was Updated Successfully');
    }

    //DELETE EXISTING MENU DETAIL

    public function deleteMenuDetail($pos_menu_detail_id)

    {

        MenuDetail::destroy($pos_menu_detail_id);

        return redirect('menu_detail')->with('success', 'Menu Detail Was Deleted!');

    }

    //CHANGE MENU DETAIL STATUS

    public function MenuDetailtoggleStatus(Request $request, $id)

    {

        $menuDetail = MenuDetail::find($id);

        if (!$menuDetail) {

            return response()->json(['success' => false, 'message' => 'Menu Detail Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $menuDetail->status = $newStatus;

        $menuDetail->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END MENU DETAIL SECTION-----------------------------------------

    //-----------------------------------------DISCOUNT TYPE SECTION-----------------------------------------

    //GET DISCOUNT TYPE INFORMATION

    public function getDiscount (Request $request){

        $getDiscount = Discount::all();

        return view('setting.discount_type', compact('getDiscount'));

    }

    //CREATE NEW DISCOUNT

    public function createDiscount(Request $request){

        $validatedData = $request->validate([

            'discount_type_name' => ['required', 'string', 'max:255'],

            'discount_type_description' => ['required', 'string', 'max:255'],

        ]);

        // Create the Discount record in the database

        Discount::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Discount Type Was Created Successfully!');

    }

    //UPDATE EXISTING DISCOUNT TYPE

    public function updateDiscount(Request $request,$pos_discount_type_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'discount_type_name' => ['required', 'string', 'max:255'],

            'discount_type_description' => ['required', 'string', 'max:255'],

        ], [

            'discount_type_name.required' => 'Please provide the name of the discount type',

            'discount_type_description.required' => 'Please input summary description',

        ]);

        // Find the Discount Type by ID

        $discount = Discount::find($pos_discount_type_id);

        // Update the Discount Type by data

        $discount->discount_type_name = $validatedData['discount_type_name'];

        $discount->discount_type_description = $validatedData['discount_type_description'];

        // Save the changes

        $discount->save();

        return redirect('/discount_type')->with('success', 'Discount Was Updated Successfully');



    }

    //DELETE EXISTING DISCOUNT

    public function deleteDiscount($pos_discount_type_id)

    {

        Discount::destroy($pos_discount_type_id);

        return redirect('discount_type')->with('success', 'Discount Type Was Deleted!');

    }

    //CHANGE DISCOUNT STATUS

    public function DiscounttoggleStatus(Request $request, $id)

    {

        $discount = Discount::find($id);

        if (!$discount) {

            return response()->json(['success' => false, 'message' => 'Discount Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $discount->status = $newStatus;

        $discount->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END DISCOUNT SECTION-----------------------------------------

    //-----------------------------------------DISCOUNT DETAIL SECTION-----------------------------------------

    //GET DISCOUNT DETAIL INFORMATION

    public function getDiscountDetail (Request $request){

        $getDiscount = Discount::all();

        $getDiscountDetail = DiscountDetail::all();

        return view('setting.discount_detail', compact('getDiscountDetail', 'getDiscount'));

    }

    //CREATE NEW DISCOUNT

    public function createDiscountDetail(Request $request){

        $validatedData = $request->validate([

            'pos_discount_type_id' => 'required|integer',

            'discount_percentage' => 'required|integer',

            'expiry_date' => 'nullable|date',



        ]);

        // Create the Discount record in the database

        DiscountDetail::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Discount Detail Was Created Successfully!');

    }

    //UPDATE EXISTING DISCOUNT DETAIL

    public function updateDiscountDetail(Request $request,$pos_discount_detail_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'pos_discount_type_id' => 'required|integer',

            'discount_percentage' => 'required|integer',

            'expiry_date' => 'nullable|date',

        ], [

            'pos_discount_type_id.required' => 'Please provide the name of the discount type',

            'discount_percentage.required' => 'Please input value in percentage',

        ]);

        //Find the Discount Detail by ID

        $discountdetail = DiscountDetail::find($pos_discount_detail_id);

        //Update the Discount Detail by data

        $discountdetail->pos_discount_type_id = $validatedData['pos_discount_type_id'];

        $discountdetail->discount_percentage = $validatedData['discount_percentage'];

        $discountdetail->expiry_date = $validatedData['expiry_date'];

        //Save the changes

        $discountdetail->save();

        return redirect('/discount_detail')->with('success', 'Discount Detail Was Updated Successfully');

    }

    //DELETE EXISTING DISCOUNT DETAIL

    public function deleteDiscountDetail($pos_discount_detail_id)

    {

        DiscountDetail::destroy($pos_discount_detail_id);

        return redirect('discount_detail')->with('success', 'Discount Detail Was Deleted!');

    }

    //CHANGE DISCOUNT STATUS

    public function DiscountDetailtoggleStatus(Request $request, $id)

    {

        $discountdetail = DiscountDetail::find($id);

        if (!$discountdetail) {

            return response()->json(['success' => false, 'message' => 'Discount Detail Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $discountdetail->status = $newStatus;

        $discountdetail->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END DISCOUNT SECTION-----------------------------------------

    //-----------------------------------------PROMOTION SECTION-----------------------------------------

    //GET PROMOTION INFORMATION

    public function getPromotion (Request $request){

        $getPromotion = Promotion::all();

        return view('setting.promotion', compact('getPromotion'));

    }

    //CREATE NEW PROMOTION

    public function createPromotion(Request $request){

        $validatedData = $request->validate([

            'promotion_name' => ['required', 'string', 'max:255'],

            'pos_promotion_type_id' => ['required', 'integer'],

        ]);

        // Create the Promotion record in the database



        Promotion::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Promotion Was Created Successfully!');



    }

    //UPDATE EXISTING PROMOTION

    public function updatePromotion(Request $request,$pos_promotion_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'promotion_name' => ['required', 'string', 'max:255'],

            'pos_promotion_type_id' => ['required', 'integer'],

        ], [

            'promotion_name.required' => 'Please input summary description',

            'pos_promotion_type_id.required' => 'Please Select Menu Name',

            'Size_id.required' => 'Please Select Size Name',

            'price.required' => 'Please provide the price',

            'Currency_id.required' => 'Please Select Currency Name',

        ]);

        // Find the Promotion by ID

        $promotion = Promotion::find($pos_promotion_id);

        // Update the Promotion by data

        $promotion->promotion_name = $validatedData['promotion_name'];

        $promotion->pos_promotion_type_id = $validatedData['pos_promotion_type_id'];

        // Save the changes

        $promotion->save();

        return redirect('/promotion')->with('success', 'Promotion Was Updated Successfully');



    }

    //DELETE EXISTING PROMOTION

    public function deletePromotion($pos_promotion_id)

    {

        Promotion::destroy($pos_promotion_id);

        return redirect('promotion_')->with('success', 'Promotion Was Deleted!');

    }

    //CHANGE PROMOTION STATUS

    public function PromotiontoggleStatus(Request $request, $id)

    {

        $promotion = Promotion::find($id);

        if (!$promotion) {

            return response()->json(['success' => false, 'message' => 'Promotion Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $promotion->status = $newStatus;

        $promotion->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END PROMOTION SECTION-----------------------------------------

    //-----------------------------------------PROMOTION TYPE SECTION-----------------------------------------

    //GET PROMOTION TYPE INFORMATION

    public function getPromotionType (Request $request){

        $getPromotionType = PromotionType::all();

        return view('setting.promotion_type', compact('getPromotionType'));

    }

    //CREATE NEW PROMOTION TYPE

    public function createPromotionType(Request $request){

        $validatedData = $request->validate([

            'promotion_type_description' => ['required', 'string', 'max:255'],

            'promotion_type_name' => ['required', 'string', 'max:255'],

        ]);

        // Create the Promotion Type record in the database



        PromotionType::create($validatedData);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Promotion Type Was Created Successfully!');



    }

    //UPDATE EXISTING PROMOTION TYPE

    public function updatePromotionType(Request $request,$pos_promotion_type_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'promotion_type_name' => ['required', 'string', 'max:255'],

            'promotion_type_description' => ['required', 'string', 'max:255'],

        ], [

            'promotion_type_name.required' => 'Please input pomotion type name',

            'promotion_type_description.required' => 'Please input summary description',

        ]);

        // Find the Promotion Type by ID

        $promotionType = PromotionType::find($pos_promotion_type_id);

        // Update the Promotion by data

        $promotionType->promotion_type_name = $validatedData['promotion_type_name'];

        $promotionType->promotion_type_description = $validatedData['promotion_type_description'];

        // Save the changes

        $promotionType->save();

        return redirect('/promotion_type')->with('success', 'Promotion Type Was Updated Successfully');



    }

    //DELETE EXISTING PROMOTION TYPE

    public function deletePromotionType($pos_promotion_type_id)

    {

        PromotionType::destroy($pos_promotion_type_id);

        return redirect('promotion_type')->with('success', 'Promotion Type Was Deleted!');

    }

    //CHANGE PROMOTION TYPE STATUS

    public function PromotionTypetoggleStatus(Request $request, $id)

    {

        $promotionType = PromotionType::find($id);

        if (!$promotionType) {

            return response()->json(['success' => false, 'message' => 'Promotion Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $promotionType->status = $newStatus;

        $promotionType->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END PROMOTION TYPE SECTION-----------------------------------------

    //-----------------------------------------PROMOTION DETAIL SECTION-----------------------------------------

    //GET PROMOTION DETAIL INFORMATION

    public function getPromotionDetail (Request $request){

        $promotionType = PromotionType::all();

        $Menu = Menu::all();

        $group = MenuGroup::all();

        $MenuCate = invMenuCate::all();

        $getPromotionDetail = PromotionDetail::all();

        $getPromotion = Promotion::all();

        return view('setting.promotion_detail', compact('getPromotionDetail', 'getPromotion', 'MenuCate', 'group', 'promotionType', 'Menu'));

    }

    //CREATE NEW PROMOTION DETAIL

    public function createPromotionDetail(Request $request){

        $request->validate([

            'promotion_detail_description' => ['required', 'string', 'max:255'],

            'pos_promotion_type_id' => ['required', 'integer'],

            'promotion_name' => ['required', 'string', 'max:255'],

            'Menu_id' => ['required', 'integer'],

            'start_date' => ['required', 'date'],

            'end_date' => ['required', 'date'],

        ]);

        //Create new Promotion into database

        $promotion = Promotion::create([

            'promotion_name' => $request->promotion_name,

            'pos_promotion_type_id' => $request->pos_promotion_type_id,

        ]);

        // Create the Promotion Detail record in the database

        PromotionDetail::create([

            'promotion_detail_description' => $request->promotion_detail_description,

            'pos_promotion_id' => $promotion->pos_promotion_id,

            'Menu_id' => $request->Menu_id,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,

        ]);

        // Redirect or return a response

        return redirect()->back()->with('success', 'Promotion Detail Was Created Successfully!');

    }

    //UPDATE EXISTING PROMOTION DETAIL

    public function updatePromotionDetail(Request $request,$pos_promotion_detail_id)

    {

        // Validate the request data

        $validatedData = $request->validate([

            'promotion_detail_description' => ['required', 'string', 'max:255'],

            'pos_promotion_type_id' => ['required', 'integer'],

            'promotion_name' => ['required', 'string', 'max:255'],

            'Menu_id' => ['required', 'integer'],

            'start_date' => ['required', 'date'],

            'end_date' => ['required', 'date'],

        ], [

            'promotion_detail_description.required' => 'Please input summary description',

            'promotion_name.required' => 'Please input promotion name',

            'pos_promotion_type_id.required' => 'Please input promotion type name',

            'Menu_id.required' => 'Please input menu name',

            'start_date.required' => 'Please input start date',

            'end_date.required' => 'Please input end date',

        ]);

        // Find the Promotion Detail by ID

        $promotionDetailID = PromotionDetail::find($pos_promotion_detail_id);

        // Update the Promotion Detail by data

        $promotionDetailID->promotion_detail_description = $validatedData['promotion_detail_description'];

        $promotionDetailID->pos_promotion_id = $request['pos_promotion_id'];

        $promotionDetailID->Menu_id = $validatedData['Menu_id'];

        $promotionDetailID->start_date = $validatedData['start_date'];

        $promotionDetailID->end_date = $validatedData['end_date'];

        // Save the changes

        $promotionDetailID->save();



        //Find the promotion by ID

        $promotionID = Promotion::find($promotionDetailID->pos_promotion_id);

        //Update promotion table

        $promotionID->promotion_name = $validatedData['promotion_name'];

        $promotionID->pos_promotion_type_id = $validatedData['pos_promotion_type_id'];

        //Save promotion

        $promotionID->save();



        return redirect('/promotion_detail')->with('success', 'Promotion Type Was Updated Successfully');



    }

    //DELETE EXISTING PROMOTION DETAIL

    public function deletePromotionDetail($pos_promotion_detail_id)

    {

        PromotionDetail::destroy($pos_promotion_detail_id);

        return redirect('promotion_detail')->with('success', 'Promotion Detail Was Deleted!');

    }

    //CHANGE PROMOTION DETAIL STATUS

    public function PromotionDetailtoggleStatus(Request $request, $id)

    {

        $promotionDetail = PromotionDetail::find($id);

        if (!$promotionDetail) {

            return response()->json(['success' => false, 'message' => 'Promotion Detail Was Not Found'], 404);

        }

        $newStatus = $request->input('status');

        $promotionDetail->status = $newStatus;

        $promotionDetail->save();

        return response()->json(['success' => true, 'status' => $newStatus]);

    }

    //-----------------------------------------END PROMOTION DETAIL SECTION-----------------------------------------



    //-----------------------------------------END POS SETTING

    



    //-----------------------------------------MODULE INFO SETTING



    

    //-----------------------------------------MODULE SECTION-----------------------------------------
    public function indexModule()
    {
        $roles = InvRole::all();
        $sysModules = SysModule::with('modules')->get(); 
    
        return view('setting.module', compact('roles', 'sysModules'));
    }
    public function store(Request $request)
    {
        foreach ($request->input('permissions', []) as $smId => $rolePermissions) {
            foreach ($rolePermissions as $roleId => $status) {
                $isEnabled = isset($status['enabled']) && $status['enabled'] === '1' ? '1' : '0';
                Log::info('Updating permission:', [
                    'SM_id' => $smId,
                    'R_id' => $roleId,
                    'status' => $isEnabled
                ]);
                Module::updateOrCreate(
                    ['SM_id' => $smId, 'R_id' => $roleId],
                    ['status' => $isEnabled]
                );
            }
        }
    
        return redirect()->route('module.index')->with('success', 'Permissions updated successfully!');
    }

    //-----------------------------------------END MODULE SECTION-----------------------------------------







    //-----------------------------------------END MODULE INFO SETTING



    



    //-----------------------------------------MODULE INFO SETTING



    



    //-----------------------------------------END MODULE INFO SETTING



    



    



    //-----------------------------------------SYSTEM LOG SETTING



    



    //-----------------------------------------LOGIN LOGS SECTION-----------------------------------------

    public function login_logs (Request $request){
        $userLogs=LoginInfo::all();
        return view('setting.login-logs',compact('userLogs'));
    }



    //-----------------------------------------END LOGIN LOGS SECTION-----------------------------------------



    



    //-----------------------------------------OPERATION LOGS SECTION-----------------------------------------



    public function operation_logs (Request $request){

        $operationLog = OperationLog::paginate(12);

        return view('setting.operation-logs', compact('operationLog'));

    }



    //-----------------------------------------END OPERATION LOGS SECTION-----------------------------------------



    



    //-----------------------------------------END SYSTEM LOG SETTING



}



