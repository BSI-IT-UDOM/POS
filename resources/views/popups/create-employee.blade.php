<div id="createEmployeePopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-20">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">NEW EMPLOYEE</h2>

        </div>

        <form id="createEmployeeForm" action="{{ route('createEmployee') }}" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            <div class="relative text-center">

                <div class="relative inline-block">

                    <img id="emp_Photo" src="images/shop.jpg" class="h-32 w-32 rounded-full" alt="Profile">

                    <div class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 rounded-full">

                        <div class="p-2 cursor-pointer hover:bg-opacity-75 transition rounded-full" onclick="document.getElementById('emp_photo').click();">

                            <i class="fas fa-edit text-white"></i>

                        </div>

                    </div>

                </div>

                <input type="file" id="emp_photo" name="emp_photo" class="hidden" onchange="previewImage(event)">

            </div>

            <div class="flex px-8">

                <div class="p-2 w-full">

                    <div class="mb-8">

                        <label for="employee_id" class="block mb-1">ID :</label>

                        <input type="text" id="employee_id" name="employee_id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>

                    <div class="mb-4">

                        <label for="emp_title" class="block mb-1">TITLE:</label>

                        <select  id="emp_title" name="emp_title" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                            <option value="">-- TITLE --</option>

                            <option value="Mr.">Mr.</option>

                            <option value="Mrs.">Mrs.</option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label for="emp_fullname" class="block mb-1">FULL NAME:</label>

                        <input type="text" id="emp_fullname" name="emp_fullname" class="text-center w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>

                    <div class="mb-4">

                        <label for="emp_contact" class="block mb-1">CONTACT :</label>

                        <input type="text" id="emp_contact" name="emp_contact" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>

                    <div class="mb-4">

                        <label for="emp_address" class="block mb-1">ADDRESS :</label>

                        <input type="text" id="emp_address" name="emp_address" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>

                </div>

                <div class="p-2 w-full">

                    <div class="mb-4">

                        <label for="position_id" class="block mb-1">POSITION :</label>

                        <select  id="position_id" name="position_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                            <option value="">-- POSITION --</option>

                            <option value="createPostion">++ CREATE NEW ++</option>

                            @foreach ($position as $position)

                                <option value="{{ $position->position_id }}">{{ $position->position_name }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label for="S_id" class="block mb-1">SHOP : </label>

                        <select  id="S_id" name="S_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                            <option value="" disabled selected>-- SHOP --</option>

                            <option value="createShop">++ CREATE NEW ++</option>

                            @foreach ($shop as $data)

                                <option value="{{ $data->S_id }}">{{ $data->S_name }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label for="L_id" class="block">LOCATION :</label>

                        <select id="L_id" name="L_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                            <option value="">-- LOCATION --</option>

                            <option value="createLocation">++ CREATE NEW ++</option>

                            @foreach ($location as $data)

                                <option value="{{ $data->L_id }}">{{ $data->L_address }}</option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div> 

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="cancelCreateEmployee" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

</div>
<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('cancelCreateEmployee').addEventListener('click', function() {

        document.getElementById('createEmployeePopup').classList.add('hidden');

        document.getElementById('createEmployeeForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('createEmployeePopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

</script>



<style>

    .is-invalid {

        border-color: #dc3545;

    }



    .invalid-feedback {

        color: #dc3545;

        font-size: 0.875rem;

        margin-top: 0.25rem;

    }

</style>

