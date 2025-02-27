<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Profit_LoseController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IngredientReController;
use App\Models\Employee;

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/

Route::get('/', function () {

    return view('welcome');

});

Auth::routes();

//-------------------------------------------------------HOME PAGE-------------------------------------------------------
//display home page
Route::get('/home', [HomeController::class, 'index'])->name('home');



//-------------------------------------------------------DASHBOARD PAGE-------------------------------------------------------
//display dashboard page
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



//-------------------------------------------------------INVENTORY PAGE-------------------------------------------------------
//display inventory information
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
//search inventory
Route::get('/inventory/search', [InventoryController::class, 'search'])->name('inventory.search');



//-------------------------------------------------------SUPPLIER PAGE-------------------------------------------------------
//display supplier information
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
//create new supplier
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
//delete existing supplier
Route::get('supplier/destroy/{Sup_id}', [SupplierController::class, 'destroy']);
//update existing  supplier
Route::patch('/supplier_update/{Sup_id}', [SupplierController::class, 'update'])->name('supplier.update');
//search supplier
Route::get('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
//update status of supplier
Route::post('/supplier/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('material.toggle-status');



//-------------------------------------------------------MATERIAL PAGE-------------------------------------------------------
//display material information
Route::get('/material', [MaterialController::class, 'index'])->name('material');
//create new material
Route::post('/material', [MaterialController::class, 'store'])->name('material.store');
//delete existing material
Route::get('material/destroy/{Material_id}', [MaterialController::class, 'destroy']);
//search material
Route::get('/material/search', [MaterialController::class, 'search'])->name('material.search');
//update existing material
Route::patch('/material_update/{Material_id}', [MaterialController::class, 'update'])->name('material.update');
//change material status
Route::post('/material/{id}/toggle-status', [MaterialController::class, 'toggleStatus'])->name('material.toggle-status');



//-------------------------------------------------------ORDER PAGE-------------------------------------------------------
//display order information
Route::get('/order', [OrderController::class, 'index'])->name('order');
//create new order
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
//delete existing order
Route::get('order/destroy/{Order_Info_id}', [OrderController::class, 'destroy']);
//update existing order
Route::patch('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
//search order
Route::get('/order/search', [OrderController::class, 'search'])->name('order.search');



//-------------------------------------------------------POS PAGE-------------------------------------------------------
//display POS page
Route::get('/pos', [POSController::class, 'index'])->name('pos');
//create sale transaction
Route::post('/pos', [POSController::class, 'store'])->name('pos.store');

//-------------------------------------------------------REPORT PAGE-------------------------------------------------------
//display report page
Route::get('/report', [ReportController::class, 'index'])->name('report.index');



//-------------------------------------------------------PROFIT / LOSE PAGE-------------------------------------------------------
//display profit / lose page
Route::get('/profit_lose', [Profit_LoseController::class, 'index'])->name('profit_lose');



//-------------------------------------------------------SETTING PAGE-------------------------------------------------------
//display setting page
Route::get('/setting', [SettingController::class, 'index'])->name('setting');



//-------------------------------------------------------MENU PAGE-------------------------------------------------------
//display menu information
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
//create new menu
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
//delete existing menu
Route::get('menu/destroy/{Menu_id}', [MenuController::class, 'destroy']);
//search menu
Route::get('/menu/search', [MenuController::class, 'search'])->name('menu.search');
//update existing menu
Route::patch('/menu/{Menu_id}', [MenuController::class, 'update'])->name('menu.update');
//update status menu
Route::post('/menu/{id}/toggle-status', [MenuController::class, 'toggleStatus'])->name('material.toggle-status');



//-------------------------------------------------------ADD-ON PAGE-------------------------------------------------------
//display add-on information
Route::get('/add-on', [SettingController::class, 'addon'])->name('add-on');
//create new add-on
Route::post('/add-on', [SettingController::class, 'createAddon'])->name('add-on.store');
//delete existing add-on
Route::get('add-on/destroy/{Addons_id}', [SettingController::class, 'Addondestroy']);
//search add-on
Route::get('/add-on/search', [SettingController::class, 'Addonsearch'])->name('add-on.search');
//update existing add-on
Route::patch('/add-on/{Addons_id}', [SettingController::class, 'Addonupdate'])->name('add-on.update');
//update status add-on
Route::post('/add-on/{id}/toggle-status', [SettingController::class, 'AddontoggleStatus'])->name('material.toggle-status');



//-------------------------------------------------------REGISTER PAGE-------------------------------------------------------
//display register page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//create register
Route::post('/register', [RegisterController::class, 'register']);




//-------------------------------------------------------SHOP PAGE-------------------------------------------------------
//display shop information
Route::get('/shop', [SettingController::class, 'shop'])->name('shop');
//create new shop
Route::post('/shop', [SettingController::class, 'ShopOperation'])->name('createShop');
//update existing shop
Route::patch('/shop/{S_id}', [SettingController::class, 'ShopOperation'])->name('updateShop');



//-------------------------------------------------------LOCATION PAGE-------------------------------------------------------
//display location information
Route::get('/location', [SettingController::class, 'location'])->name('location');
//create new location
Route::post('/location', [SettingController::class, 'upddatelocation'])->name('upddatelocation');


//-------------------------------------------------------USER PAGE-------------------------------------------------------
//display user information
Route::get('/user', [SettingController::class, 'viewUser'])->name('user');
//Create new User
Route::post('/user', [SettingController::class, 'createUser'])->name('createUser');
//Update existing User
Route::patch('/user/{U_id}', [SettingController::class, 'updateUser'])->name('updateUser');
//Update status of user
Route::post('/user/{id}/toggle-status', [SettingController::class, 'toggleStatus']);


//-------------------------------------------------------PROFILE POPUP-------------------------------------------------------
Route::patch('/profile/{U_id}', [UserController::class, 'update'])->name('home.update');


//-------------------------------------------------------UOM PAGE-------------------------------------------------------
//display uom information
Route::get('/uom', [SettingController::class, 'uom'])->name('uom');
//create new uom
Route::post('/uom', [SettingController::class, 'createUOM'])->name('createUOM');
//delete existing uom
Route::get('/uom/destroy/{UOM_id}', [SettingController::class, 'UOMdestroy']);
//update existing uom
Route::patch('/uom/{UOM_id}', [SettingController::class, 'UOMupdate'])->name('UOMupdate');
//update status currency
Route::post('/uom/{id}/toggle-status', [SettingController::class, 'UOMtoggleStatus'])->name('uom.toggle-status');



//-------------------------------------------------------CURRENCY PAGE-------------------------------------------------------
//display currency information
Route::get('/currency', [SettingController::class, 'currency'])->name('currency');
//create new currency
Route::post('/currency', [SettingController::class, 'createCurrency'])->name('createCurrency');
//delete existing currency
Route::get('/currency/destroy/{Currency_id}', [SettingController::class, 'Currencydestroy']);
//update existing currency
Route::patch('/currency/{Currency_id}', [SettingController::class, 'Currencyupdate'])->name('Currencyupdate');
//update status currency
Route::post('/currency/{id}/toggle-status', [SettingController::class, 'CurrencytoggleStatus'])->name('currency.toggle-status');

//-------------------------------------------------------PAYMENT-METHOD PAGE-------------------------------------------------------
//display payment method
Route::get('/payment', [SettingController::class, 'payment'])->name('payment');
//create new payment method
Route::post('/payment', [SettingController::class, 'createPayment'])->name('createPayment');
//delete existing payment method
Route::get('/payment/destroy/{IPM_id}', [SettingController::class, 'Paymentdestroy']);
//update existing payment method
Route::patch('/payment/{IPM_id}', [SettingController::class, 'Paymentupdate'])->name('Paymentupdate');
//update status payment method
Route::post('/payment/{id}/toggle-status', [SettingController::class, 'PaymenttoggleStatus'])->name('payment.toggle-status');

//-------------------------------------------------------PAYMENT-METHOD CATEGORY PAGE-------------------------------------------------------
//display payment method category method
Route::get('/payment_category', [SettingController::class, 'paymentCate'])->name('paymentCate');
//create new payment method category
Route::post('/payment_category', [SettingController::class, 'createPaymentCate'])->name('createPaymentCate');
//delete existing payment method category
Route::get('/payment_category/destroy/{PMCate_id}', [SettingController::class, 'PaymentCatedestroy']);
//update existing payment method category
Route::patch('/payment_category/{PMCate_id}', [SettingController::class, 'PaymentCateupdate'])->name('PaymentCateupdate');
//update status payment method category
Route::post('/payment_category/{id}/toggle-status', [SettingController::class, 'PaymentCatetoggleStatus'])->name('payment_category.toggle-status');

//-------------------------------------------------------SIZE PAGE-------------------------------------------------------
//display size information
Route::get('/size', [SettingController::class, 'size'])->name('size');
//create new size
Route::post('/size', [SettingController::class, 'createSize'])->name('createSize');
//delete existing size
Route::get('size/destroy/{Size_id}', [SettingController::class, 'Sizedestroy']);
//update existing size
Route::patch('/size/{Size_id}', [SettingController::class, 'Sizeupdate'])->name('Sizeupdate');
//update status Size
Route::post('/size/{id}/toggle-status', [SettingController::class, 'SizetoggleStatus'])->name('size.toggle-status');


//-------------------------------------------------------MODULE PAGE-------------------------------------------------------
//display module information
Route::get('/module', [SettingController::class, 'indexModule'])->name('module.index'); // For displaying the page
Route::post('/module/store', [SettingController::class, 'store'])->name('module.store'); // For storing the form data
//update existing module


//-------------------------------------------------------MENU GROUP PAGE-------------------------------------------------------
//display menu group information
Route::get('/menu_group', [SettingController::class, 'menu_group'])->name('menu_group');
//create new menu group
Route::post('/menu_group', [SettingController::class, 'createMenuGr'])->name('createMenuGr');
//delete existing menu group
Route::get('menu_group/destroy/{MenuGr_id}', [SettingController::class, 'MenuGrdestroy']);
//update existing menu group
Route::patch('/menu_group/{MenuGr_id}', [SettingController::class, 'MenuGrupdate'])->name('MenuGrupdate');
//update Menu Group status
Route::post('/menu_group/{id}/toggle-status', [SettingController::class, 'MenuGrtoggleStatus'])->name('menu_group.toggle-status');

//-------------------------------------------------------MENU CATEGORY PAGE-------------------------------------------------------
//display menu category information
Route::get('/menu_category', [SettingController::class, 'menuCat'])->name('menuCat');
//create new menu category
Route::POST('/menu_category', [SettingController::class, 'createMenuCate'])->name('createMenuCate');
//delete existing menu category
Route::get('menu_category/destroy/{Menu_Cate_id}', [SettingController::class, 'MenuCatedestroy']);
//update existing menu category
Route::patch('/menu_category/{Menu_Cate_id}', [SettingController::class, 'MenuCateupdate'])->name('MenuCateupdate');
//update Menu Group status
Route::post('/menu_category/{id}/toggle-status', [SettingController::class, 'MenuCatetoggleStatus'])->name('menu_category.toggle-status');

//-------------------------------------------------------INGREDIENT PAGE-------------------------------------------------------
//display ingredient information
Route::get('/ingredient', [SettingController::class, 'ingredient'])->name('ingredient');
//create new ingredient
Route::post('/ingredients', [SettingController::class, 'creatIng'])->name('createIng');
//add more ingredient
Route::post('/ingredient/add', [SettingController::class, 'addIng'])->name('addIng');
//delete existing ingredient

//update existing ingredient
Route::patch('/ingredient/edit/{Menu_id}', [SettingController::class, 'updateIngredients'])->name('updateIngredients');
//create new ingredient
Route::post('/ingredient', [IngredientReController::class, 'create'])->name('createIngredient');
// search ingredient
Route::get('/ingredient/search', [SettingController::class, 'Ingredientsearch'])->name('ingredient.search');
//update status
Route::post('/ingredient/{id}/toggle-status', [SettingController::class, 'IngredienttoggleStatus'])->name('ingredient.toggle-status');

//-------------------------------------------------------OWNER PAGE-------------------------------------------------------
//display owner information
Route::get('/owner', [SettingController::class, 'owner'])->name('owner');
//update owner


//-------------------------------------------------------ROLE PAGE-------------------------------------------------------
//display role information
Route::get('/role', [SettingController::class, 'role'])->name('role');
//create new role
Route::post('/role', [SettingController::class, 'createRole'])->name('createRole');
//delete existing role
Route::get('/role/destroy/{R_id}', [SettingController::class, 'Roledestroy']);
//update existing role
Route::patch('/role/{R_id}', [SettingController::class, 'Roleupdate'])->name('Roleupdate');
//update status add-on
Route::post('/role/{id}/toggle-status', [SettingController::class, 'RoletoggleStatus'])->name('role.toggle-status');

//-------------------------------------------------------POSITION PAGE-------------------------------------------------------
//display position information
Route::get('/position', [SettingController::class, 'position'])->name('position');
//create new position
Route::post('/position', [SettingController::class, 'createPosition'])->name('createPosition');
//delete existing position
Route::get('/position/destroy/{position_id}', [SettingController::class, 'destroyPosition']);
//update existing position
Route::patch('/position/{position_id}', [SettingController::class, 'updatePosition'])->name('updatePosition');
//update status add-on
Route::post('/position/{id}/toggle-status', [SettingController::class, 'PositiontoggleStatus'])->name('position.toggle-status');


//-------------------------------------------------------EXPENSE PAGE-------------------------------------------------------
//display expense information
Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');
//create new expense
Route::post('/expense', [ExpenseController::class, 'createExpense'])->name('createExpense');
//delete existing expense
//update existing expense


//-------------------------------------------------------EXPENSE CATEGORY PAGE-------------------------------------------------------
//display expense category information
Route::get('/expense_category', [SettingController::class, 'expenseCat'])->name('expense_category');
//create new expense category
Route::post('/expense_category', [SettingController::class, 'createExpenseCate'])->name('createExpenseCate');
//delete existing expense category
Route::get('/expense_category/destroy/{IEC_id}', [SettingController::class, 'ExpenseCatedestroy']);
//update existing expense category
Route::patch('/expense_category/{IEC_id}', [SettingController::class, 'ExpenseCateupdate'])->name('ExpenseCateupdate');
//update status expense category
Route::post('/expense_category/{id}/toggle-status', [SettingController::class, 'ExpenseCatetoggleStatus'])->name('expense_category.toggle-status');

//-------------------------------------------------------INCOME PAGE-------------------------------------------------------
//display income category information
Route::get('/income', [IncomeController::class, 'index'])->name('income');
//create new income category
Route::post('/income', [IncomeController::class, 'createincome'])->name('createincome');
//delete existing income category
Route::get('/income/destroy/{income_id}', [IncomeController::class, 'incomedestroy']);
//update existing income category
Route::patch('/income/{income_id}', [IncomeController::class, 'incomeupdate'])->name('incomeupdate');
//update status income
Route::post('/income/{id}/toggle-status', [IncomeController::class, 'incometoggleStatus'])->name('income.toggle-status');

//-------------------------------------------------------INCOME CATEGORY PAGE-------------------------------------------------------
//display income category information
Route::get('/income_category', [SettingController::class, 'incomeCate'])->name('income_category');
//create new income category
Route::post('/income_category', [SettingController::class, 'createIncomeCate'])->name('createIncomeCate');
//delete existing income category
Route::get('/income_category/destroy/{IC_id}', [SettingController::class, 'IncomeCatedestroy']);
//update existing income category
Route::patch('/income_category/{IC_id}', [SettingController::class, 'IncomeCateupdate'])->name('IncomeCateupdate');
//update status income category
Route::post('/income_category/{id}/toggle-status', [SettingController::class, 'IncomeCatetoggleStatus'])->name('income_category.toggle-status');


//-------------------------------------------------------LOGIN INFO PAGE----------------------------------------------------
//display login info logs
Route::get('/login_logs', [SettingController::class, 'login_logs'])->name('login_logs');

//-------------------------------------------------------OPERATION INFO PAGE----------------------------------------------------
//display operation info logs
Route::get('/operation_logs', [SettingController::class, 'operation_logs'])->name('operation_logs');

//-------------------------------------------------------MATERIAL GROUP PAGE-------------------------------------------------------
//display material group information
Route::get('/material_group', [SettingController::class, 'material_group'])->name('material_group');
//create new material group
Route::post('/material_group', [SettingController::class, 'createMaterialGr'])->name('createMaterialGr');
//delete existing material group
Route::get('/material_group/destroy/{IMG_id}', [SettingController::class, 'MaterialGrdestroy']);
//update existing material group
Route::patch('/material_group/{IMG_id}', [SettingController::class, 'MaterialGrupdate'])->name('MaterialGrupdate');
//update status material group
Route::post('/material_group/{id}/toggle-status', [SettingController::class, 'MaterialGrtoggleStatus'])->name('material_group.toggle-status');

//-------------------------------------------------------MATERIAL CATEGORY PAGE-------------------------------------------------------
//display material category information
Route::get('/material_category', [SettingController::class, 'materialCat'])->name('material_category');
//create new material category
Route::post('/material_category', [SettingController::class, 'createMaterialCate'])->name('createMaterialCate');
//delete existing material category
Route::get('/material_category/destroy/{Material_Cate_id}', [SettingController::class, 'MaterialCatedestroy']);
//update existing material category
Route::patch('/material_category/{Material_Cate_id}', [SettingController::class, 'MaterialCateupdate'])->name('MaterialCateupdate');
//update status material category
Route::post('/material_category/{id}/toggle-status', [SettingController::class, 'MaterialCatetoggleStatus'])->name('material_category.toggle-status');

//-------------------------------------------------------EMPLOYEE PAGE-------------------------------------------------------
//display employee information
Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
//create new employee
Route::post('/employee', [EmployeeController::class, 'createEmployee'])->name('createEmployee');
//delete existing employee
Route::get('/employee/destroy/{emp_id}', [EmployeeController::class, 'deleteEmployee']);
//update existing employee
Route::patch('/employee/{emp_id}', [EmployeeController::class, 'updateEmployee'])->name('updateEmployee');
//update status employee
Route::post('/employee/{id}/toggle-status', [EmployeeController::class, 'EmployeetoggleStatus'])->name('employee.toggle-status');

//-------------------------------------------------------TABLE PAGE-------------------------------------------------------
//display table information
Route::get('/table_setting', [SettingController::class, 'getTable'])->name('getTable');
//create new table
Route::post('/table_setting', [SettingController::class, 'createTable'])->name('createTable');
//delete existing table
Route::get('/table_setting/destroy/{pos_table_id}', [SettingController::class, 'deleteTable']);
//update existing table
Route::patch('/table_setting/{pos_table_id}', [SettingController::class, 'updateTable'])->name('updateTable');
//update status table
Route::post('/table_setting/{id}/toggle-status', [SettingController::class, 'TabletoggleStatus'])->name('table_setting.toggle-status');

//-------------------------------------------------------MENU DETAIL PAGE-------------------------------------------------------
//display menu detail
Route::get('/menu_detail', [SettingController::class, 'getMenuDetail'])->name('getMenuDetail');
//create new menu detail
Route::post('/menu_detail', [SettingController::class, 'mapMenuDetail'])->name('mapMenuDetail');
//add more menuDetail
Route::post('/menu_detail/add', [SettingController::class, 'addMenuDetail'])->name('addMenuDetail');
//delete existing menu detail
Route::get('/menu_detail/destroy/{pos_menu_detail_id}', [SettingController::class, 'deleteMenuDetail']);
//update existing menu detail
Route::patch('/menu_detail/{pos_menu_detail_id}', [SettingController::class, 'updateMenuDetail'])->name('updateMenuDetail');
//update status menu detail
Route::post('/menu_detail/{id}/toggle-status', [SettingController::class, 'MenuDetailtoggleStatus'])->name('menu_detail.toggle-status');

//-------------------------------------------------------DISCOUNT PAGE-------------------------------------------------------
//display discount type information
Route::get('/discount_type', [SettingController::class, 'getDiscount'])->name('getDiscount');
//create new discount type
Route::post('/discount_type', [SettingController::class, 'createDiscount'])->name('createDiscount');
//delete existing discount type
Route::get('/discount_type/destroy/{pos_discount_type_id}', [SettingController::class, 'deleteDiscount']);
//update existing discount type
Route::patch('/discount_type/{pos_discount_type_id}', [SettingController::class, 'updateDiscount'])->name('updateDiscount');
//update status discount type
Route::post('/discount_type/{id}/toggle-status', [SettingController::class, 'DiscounttoggleStatus'])->name('discount.toggle-status');

//display discount detail information
Route::get('/discount_detail', [SettingController::class, 'getDiscountDetail'])->name('getDiscountDetail');
//create new discount detail
Route::post('/discount_detail', [SettingController::class, 'createDiscountDetail'])->name('createDiscountDetail');
//delete existing discount detail
Route::get('/discount_detail/destroy/{pos_discount_detail_id}', [SettingController::class, 'deleteDiscountDetail']);
//update existing discount detail
Route::patch('/discount_detail/{pos_discount_detail_id}', [SettingController::class, 'updateDiscountDetail'])->name('updateDiscountDetail');
//update status discount detail
Route::post('/discount_detail/{id}/toggle-status', [SettingController::class, 'DiscountDetailtoggleStatus'])->name('discount_detail.toggle-status');

//-------------------------------------------------------PROMOTION PAGE-------------------------------------------------------
//display promotion type information
Route::get('/promotion_type', [SettingController::class, 'getPromotionType'])->name('getPromotionType');
//create new promotion type
Route::post('/promotion_type', [SettingController::class, 'createPromotionType'])->name('createPromotionType');
//delete existing promotion type
Route::get('/promotion_type/destroy/{pos_promotion_type_id}', [SettingController::class, 'deletePromotionType']);
//update existing promotion type
Route::patch('/promotion_type/{pos_promotion_type_id}', [SettingController::class, 'updatePromotionType'])->name('updatePromotionType');
//update status promotion type
Route::post('/promotion_type/{id}/toggle-status', [SettingController::class, 'PromotionTypetoggleStatus'])->name('promotion_type.toggle-status');

//display promotion detail information
Route::get('/promotion_detail', [SettingController::class, 'getPromotionDetail'])->name('getPromotionDetail');
//create new promotion detail
Route::post('/promotion_detail', [SettingController::class, 'createPromotionDetail'])->name('createPromotionDetail');
//delete existing promotion detail
Route::get('/promotion_detail/destroy/{pos_promotion_detail_id}', [SettingController::class, 'deletePromotionDetail']);
//update existing promotion detail
Route::patch('/promotion_detail/{pos_promotion_detail_id}', [SettingController::class, 'updatePromotionDetail'])->name('updatePromotionDetail');
//update status promotion detail
Route::post('/promotion_detail/{id}/toggle-status', [SettingController::class, 'PromotionDetailtoggleStatus'])->name('promotion_detail.toggle-status');

//-------------------------------------------------------POS PAGE-------------------------------------------------------
//display POS system
Route::get('/table', [POSController::class, 'show'])->name('table');
//Submit Order
Route::post('/order-submit', [POSController::class, 'submitOrder'])->name('order.submit');
//check bill
Route::post('/order/checkbill', [POSController::class, 'checkBill'])->name('order.checkbill');