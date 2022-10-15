<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use URL;
use File;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy("created_at", "DESC")->paginate(9);
        $users = \DB::table('users')->orderBy("created_at", "DESC")->paginate(2);

            $data = array(
            'users' => $users,
            );

        return view('employee.employeeIndex',$data);
    }

    public function Create()
    {
        $users = User::orderBy("created_at", "DESC")->paginate(9);

            $data = array(
            'users' => $users,
            );

        return view('employee.create',$data);
    }

    public function Store(Request $request)
    {
        $storeData = $request->validate([
            'name' => 'required',
            'password' => 'min:6',
        ]);

        $user =
            User::create([
                'name'  => $request->name,
                'email'  => null,
                'role'  => $request->role,
                'department'  => $request->department,
                'password'  => Hash::make($request->password),
                'status'  => 1,
            ]);
            $id = $user->id;
            $emp_id = str_pad($id, 3, '0', STR_PAD_LEFT); 
            $User_emp = User::find($id);  
            $User_emp->Emp_ID = $request->name.'_'.$emp_id;
            $User_emp->save();

        return \Redirect::back()->with('message', 'Employee has been saved!');

    }

    public function Edit($id)
    {
        $user = User::find($id);
            $data = array(
            'user' => $user,
            );
        return view('employee.edit',$data);
    }

    public function Show($id)
    {
        $user = User::find($id);
            $data = array(
            'user' => $user,
            );
        return view('employee.show',$data);
    }


    public function Update(Request $request)
    {
        $data = $request->all();

        // dd($data);
        $user_id = $data['id'];
        $user = User::find($user_id);
        if(!empty($data['password'])){
            $password = $user->password;
        }else{
            $password = Hash::make($data['password']);
        }
        $user->name = $data['name'];
        $user->role =  $data['role'];
        $user->department = $data['department'];
        $user->password = $password;
        $user->save();


        return \Redirect::to('/home')->with(array('message' => 'Successfully Update Employee !', 'note_type' => 'success') );
    }

    public function Delete($id)
    {
        $User = User::find($id)->delete();
        return \Redirect::to('/home')->with(array('message' => 'Successfully deleted Employee !', 'note_type' => 'success') );
    }

    public function EmployeeSearch(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $query = $request->get("query");

            $show = URL::to("/employee/show");
            $edit = URL::to("/employee/edit");
            $delete = URL::to("/employee/delete");

            if ($query != "") {
                $data = User::where("name", "LIKE", "%" . $query . "%")
                    ->orWhere("role", "LIKE", "%" . $query . "%")
                    ->orWhere("department", "LIKE", "%" . $query . "%")
                    ->orWhere("Emp_ID", "LIKE", "%" . $query . "%")
                    ->orderBy("created_at", "desc")
                    ->paginate(2);
            } else {
                $data = [];
            }
            if (count($data) > 0) {
                $total_row = $data->count();
                if ($total_row > 0) {
                    foreach ($data as $row) {
                        $output .=
                            '
        <tr>
        <td>' .
                            $row->Emp_ID .
                            '</td>
        <td>' .
                            $row->name .
                            '</td>
        <td>' .
                            $row->role .
                            '</td>
        <td>' .
                            $row->department .
                            '</td>

         <td> ' .
                            "<a class='btn btn-success'  href=' $show/$row->id'>Show</i>
        </a>" .
                            '
        ' .
                            "<a class='btn btn-info'   href=' $edit/$row->id'><i class='ri-pencil-line'>Edit</i>
        </a>" .
                            '
        ' .
                            "<a class='btn btn-danger'   href=' $delete/$row->id'><i class='ri-delete-bin-line'>Delete</i>
        </a>" .
                            '
        </td>
        </tr>
        ';
                    }
                } else {
                    $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
                }
                $data = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                ];
                echo json_encode($data);
            }
        }
    }

    // Export 

    public function Employee_Export(Request $request)
    {

        $users = User::get();
  
            $file = "Employees.csv";

            $headers = [
                "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Content-Disposition" => "attachment; filename=download.csv",
                "Expires" => "0",
                "Pragma" => "public",
            ];
            if (!File::exists(public_path() . "/uploads/csv")) {
                File::makeDirectory(public_path() . "/uploads/csv");
            }
            $filename = public_path("/uploads/csv/" . $file);
            $handle = fopen($filename, "w");
            fputcsv($handle, [
                "Emp_ID",
                "Name",
                "Role",
                "Department",
            ]);
            if (count($users) > 0) {
                foreach ($users as $each_user) {
                    fputcsv($handle, [
                        $each_user->Emp_ID,
                        $each_user->name,
                        $each_user->role,
                        $each_user->department,
                    ]);
                }
            }

            fclose($handle);

            \Response::download($filename, "download.csv", $headers);

            return $file;

    }

    
}
