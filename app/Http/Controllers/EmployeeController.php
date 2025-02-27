<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Invshop;
use App\Models\InvLocation;
use App\Models\Position;
use Illuminate\Http\Request;
class EmployeeController extends Controller
{
    public function index()
    {
        $shop = Invshop::all();
        $location = InvLocation::all();
        $position = Position::all();
        $employee = Employee::all();
        return view('employee', compact('employee', 'shop', 'location', 'position'));
    }

    public function createEmployee(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'employee_id' => 'required|string|max:255',
            'emp_title' => 'required|string|max:255',
            'emp_fullname' => 'required|string|max:255',
            'emp_contact' => 'required|string|max:255',
            'emp_address' => 'required|string|max:255',
            'emp_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'S_id' => 'required|integer',
            'L_id' => 'required|integer',
            'position_id' => 'required|integer',
        ]);
        Employee::create($validatedData);
        // Redirect or return response
        return redirect()->back()->with('success', 'Employee was created successfully!');
    }

    public function updateEmployee(Request $request,$emp_id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'employee_id' => 'required|string|max:255',
            'emp_fullname' => 'required|string|max:255',
            'emp_contact' => 'required|string|max:255',
            'emp_address' => 'required|string|max:255',
            'emp_photo' => 'required|string|max:255',
            'R_id' => 'required|integer',
            'S_id' => 'required|integer',
            'position_id' => 'required|integer',
        ], [
            'employee_id.required' => 'Please input Add-on Name',
            'emp_fullname.required' => 'Please input Add-on Percentage',
            'emp_contact.required' => 'Please input Add-on Qty',
            'emp_address.required' => 'Please input Unit of Measure',
            'emp_photo.required' => 'Please input Unit of Measure',
            'R_id.required' => 'Please input Unit of Measure',
            'S_id.required' => 'Please input Unit of Measure',
            'position_id.required' => 'Please input Unit of Measure',
        ]);
        // Find the Employee by ID
        $employee = Employee::find($emp_id);
        // Update the Employee data
        $employee->employee_id = $validatedData['employee_id'];
        $employee->emp_fullname = $validatedData['emp_fullname'];
        $employee->emp_contact= $validatedData['emp_contact'];
        $employee->emp_address = $validatedData['emp_address'];
        $employee->emp_photo = $validatedData['emp_photo'];
        $employee->S_id = $validatedData['S_id'];
        $employee->L_id = $validatedData['L_id'];
        $employee->position_id = $validatedData['position_id'];
        // Save the changes
        $employee->save();
        return redirect('/employee')->with('flash_message', 'Employee Was Updated Successfully');
    }

    public function deleteEmployee($emp_id)
    {
        Employee::destroy($emp_id);
        return redirect('employee')->with('flash_message', 'Employee Was Deleted!');
    }
    //CHANGE Employee STATUS
    public function EmployeetoggleStatus(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee Was Not Found'], 404);
        }
        $newStatus = $request->input('status');
        $employee->status = $newStatus;
        $employee->save();
        return response()->json(['success' => true, 'status' => $newStatus]);
    }
}



