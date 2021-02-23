<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     *  View Page Show
     */
    public function index(){
        return view('index');
    }

    /**
     *  Insert Data in Database
     */
    public function store(Request $request){

        $photo = '';

        // Photo Processing
        if($request -> hasFile('photo')){
            $file = $request -> file('photo');
            $photo = md5(time(). rand()) . '.' . $file -> getClientOriginalExtension();
            $file -> move(public_path('photos'), $photo);
        }else{
            
            // Default Photo Storing by gender
            if($request -> gender == 'Male'){
                $photo = 'male_avatar.png';
            }elseif($request -> gender == 'Female'){
                $photo = 'female_avatar.png';
            }
        }

        // Array Processing
        $hobbies = json_encode($request -> hobbies);

        // All Data Storing
        Customer::create([
            'email' => $request -> email,
            'gender' => $request -> gender,
            'location' => $request -> location,
            'hobbies' => $hobbies,
            'photo' => $photo,

        ]);
    }



    /**
     *  Show all Records from Database
     */
    public function all(){

        $records = Customer::all();
        $output = '';
        $i = 1;
        
        foreach($records as $record){

            // Status Manage
            if($record -> status == 'active'){
                $status = '<span class="badge badge-success">active</span>';
            }else{
                $status = '<span class="badge badge-danger">inactive</span>';
            }

            // Status Button
            if($record -> status == 'active'){
                $status_btn = '<a href="#" id="status_btn" class=" ml-2" status_id="'. $record -> id .'"> <i class="fas fa-eye-slash"></i> </a>';
            }else{
                $status_btn = '<a href="#" id="status_btn" class="ml-2" status_id="'. $record -> id .'"> <i class="fas fa-eye"></i> </a>';
            }


            $get_hobbies = json_decode($record -> hobbies);
            $hobbies = implode(',', $get_hobbies);

            $output .= '<tr>';
            $output .= '<td>'. $i .'</td>';
            $output .= '<td>'. $record -> email .'</td>';
            $output .= '<td>'. $record -> gender .'</td>';
            $output .= '<td>'. $hobbies .'</td>';
            $output .= '<td>'. $record -> location .'</td>';            
            $output .= '<td><img style="width: 50px; heihgt: 50px; border-radius: 50%" src="photos/'. $record -> photo .'"></td>';
            $output .= '<td>'. $status . $status_btn .'</td>';
            $output .= '<td>
                            <a class="btn btn-sm btn-warning" href="#" id="view_btn" view_id="'. $record -> id .'"> View </a> 
                            <a class="btn btn-sm btn-info" href="#" id="edit_btn" edit_id="'. $record -> id .'"> Edit </a> 
                            <a class="btn btn-sm btn-danger" href="#" id="delete_btn" delete_id="'. $record -> id .'"> Delete </a> 

                        </td>';
            $output .= '</tr>';
            $i++;
        }

        return $output;
    }
    


    /**
     *  Profile View
     */
    public function view($id){
        // $all_customers = Customer::find($id);
        // $get_hobbies = json_decode($all_customers -> hobbies);	
		// $hobbies = implode(',', $get_hobbies);

        

        $all_customers = Customer::find($id);

        $hobbies_arr = json_decode($all_customers -> hobbies);
        $all_hobbies = implode(", ", $hobbies_arr);


        return [
            'photo' => $all_customers -> photo,
            'email' => $all_customers -> email,
            'gender' => $all_customers -> gender,
            'location' => $all_customers -> location,
            'hobbies' => $all_hobbies,
            'status' => $all_customers -> status,
        ];
    }


    




    /**
     *  Edit Profile
     */
    public function edit($id){
        $id = Customer::find($id);


        // Gender Setting
        $checked_female = ($id -> gender == "Male") ? "checked" : "" ;
        $checked_male = ($id -> gender == "Female") ? "checked" : "" ;
        $gender = '
                <input '. $checked_female .' class="form-check-input" type="radio" name="edit_gender" id="edit_male" value="Male">
                <label class="form-check-label" for="edit_male"> Male </label> <br>
                <input '. $checked_male .' class="form-check-input" type="radio" name="edit_gender" id="edit_female" value="Female">
                <label class="form-check-label" for="edit_female">  Female </label>
        ';


        // Location Setting
        $sel_bar = ($id -> location == "Barisal") ? "selected" : ""; 
        $sel_chi = ($id -> location == "Chittagong") ? "selected" : ""; 
        $sel_dha = ($id -> location == "Dhaka") ? "selected" : ""; 
        $sel_khu = ($id -> location == "Khulna") ? "selected" : ""; 
        $sel_mym = ($id -> location == "Mymensingh") ? "selected" : ""; 
        $sel_raj = ($id -> location == "Rajshahi") ? "selected" : ""; 
        $sel_ran = ($id -> location == "Rangpur") ? "selected" : ""; 
        $sel_syl = ($id -> location == "Sylhet") ? "selected" : ""; 
        $location = '
                <option disabled>- Location -</option>
                <option '. $sel_bar .' value="Barisal">Barisal</option>
                <option '. $sel_chi .' value="Chittagong">Chittagong</option>
                <option '. $sel_dha .' value="Dhaka">Dhaka</option>
                <option '. $sel_khu .' value="Khulna">Khulna</option>
                <option '. $sel_mym .' value="Mymensingh">Mymensingh</option>
                <option '. $sel_raj .' value="Rajshahi">Rajshahi</option>
                <option '. $sel_ran .' value="Rangpur">Rangpur</option>
                <option '. $sel_syl .' value="Sylhet">Sylhet</option>      
        ';


        
        // Hobbies Setting
        $get_hobbies = json_decode($id -> hobbies);

        $checked_reading = (in_array("Reading", $get_hobbies)) ? "checked" : ""; 
        $checked_writing = (in_array("Writing", $get_hobbies)) ? "checked" : "";
        $checked_painting = (in_array("Painting", $get_hobbies)) ? "checked" : "";
        $checked_travelling = (in_array("Travelling", $get_hobbies)) ? "checked" : "";
        $checked_photography = (in_array("Photography", $get_hobbies)) ? "checked" : "";
        $checked_vediography = (in_array("Vediography", $get_hobbies)) ? "checked" : "";

        $hobbies = '
                <label><b>Hobbies</b></label> <br> 
                <input '.$checked_reading.' type="checkbox" value="Reading" id="edit_reading" name="edit_hobbies[]"> <label for="edit_reading">Reading</label> <br> 

                <input '. $checked_writing .' type="checkbox" value="Writing" id="edit_writing" name="edit_hobbies[]"> <label for="edit_writing">Writing</label>  <br> 

                <input '. $checked_painting .' type="checkbox" value="Painting" id="edit_painting" name="edit_hobbies[]"> <label for="edit_painting">Painting</label>  <br> 

                <input '. $checked_travelling .' type="checkbox" value="Travelling" id="edit_travelling" name="edit_hobbies[]"> <label for="edit_travelling">Travelling</label>  <br>

                <input '. $checked_photography .' type="checkbox" value="Photography" id="edit_photography" name="edit_hobbies[]"> <label for="edit_photography">Photography</label>  <br> 

                <input '. $checked_vediography .' type="checkbox" value="Vediography" id="edit_vediography" name="edit_hobbies[]"> <label for="edit_vediography">Vediography</label>  

               <br>      
            ';

        return [
            'id' => $id -> id,
            'email' => $id -> email,
            'gender' => $gender,
            'location' => $location,
            'hobbies' => $hobbies,
            'photo' => $id -> photo,
        ];
    }



    /**
     *  Delete
     */
    public function delete($id){
        $delete = Customer::find($id);
        $delete -> delete();

        // Remove Deleted Photo
        if( file_exists('photos/' . $delete -> photo )){
            unlink('photos/' . $delete -> photo);
        }

        return true;
    }



    /**
     *  Update Profile
     */
    public function update(Request $request){

        $id = $request -> get_id; 
        $update = Customer::find($id);


        // Photo Processing
        $new_photo = '';

        if($request -> hasFile('new_photo')){
            
            $file = $request -> file('new_photo');
            $new_photo = md5(time(). rand()) . '.' . $file -> getClientOriginalExtension();
            $file -> move(public_path('photos'), $new_photo);

            // Remove Photo
            if( file_exists('photos/'.$request -> old_photo )){
                unlink('photos/'.$request -> old_photo);
            }

        }else{
            $new_photo = $request -> old_photo;
        }

        // Array Processing
        $edit_hobbies = json_encode($request -> edit_hobbies);


        

        $update -> email = $request -> edit_email;
        $update -> gender = $request -> edit_gender;
        $update -> location = $request -> edit_location;
        $update -> hobbies = $edit_hobbies;
        $update -> photo = $new_photo;

        $update -> update();      
        
    }


    /**
     *  Status
    */

    public function status($id){
        $get_id = Customer::find($id);

        if($get_id -> status == 'active'){

            $get_id -> status = 'inactive';
            $get_id -> update();

        }else{

            $get_id -> status = 'active';
            $get_id -> update();
        }
        
    }































}
