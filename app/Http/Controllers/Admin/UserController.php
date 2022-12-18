<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUsers;
use Spatie\Permission\Models\Role;
use App\Models\UserType;
use App\Models\UserStatu;
use App\Models\User_role;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Department;
use App\Models\Governances;
use App\Models\Directorate;
use App\Models\Users_of_school;
use App\Models\Users_of_directorate;
use App\Models\UserDepartment;
use App\Models\City;
use Toastr;
use DB;
use Hash;
class UserController extends Controller
{
    /***
     Display a listing of the resource.
      @return \Illuminate\Http\Response
     */
    function __construct()
    {
        
        // $this->middleware('permission:Show Users', ['only' => ['index','store']]);
        // $this->middleware('permission:Add Users', ['only' => ['create','store']]);
        // $this->middleware('permission:Edit Users', ['only' => ['edit','update']]);
        // $this->middleware('permission:Delete Users', ['only' => ['destroy']]);
        
    }

    public function index(Request $request)
    {
        
        $data = User::orderBy('id','DESC')->where('role_id','<>',1)->where('select',1)->paginate(20);
        return view('admin.users.show_users',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 20);
    }
    /***
     *  Show the form for creating a new resource.
     * ** 
     * @return \Illuminate\Http\Response
     * */
    public function create()
    {
        $data['Cities'] = City::all();
        $data['roles'] = Role::where('id','<>',1)->paginate(50);
        $data['userTypes'] = UserType::where('id','<>',1)->get();
        $data['Departments'] = Department::where('type',1)->where('select',1)->get();
        // $data['UserRoles'] = User_role::get();
        return view('admin.users.Add_user',$data);
    }
    /***
     *  Store a newly created resource in storage.
     * ** 
     * @param  \Illuminate\Http\Request  $request* 
     * @return \Illuminate\Http\Response
     * */
    public function store(StoreUsers $request)
    {
        DB::beginTransaction();
               
        try
        {

            if(isset($request->status))
            {
                $status = 1;
            }
            else{
                $status = 2;
            }

            $role_id = UserType::where('roles_name',$request->roles_name)->value('id');

            $user = new User();
            $user->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $user->username = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $user->email =  $request->email;
            $user->password = Hash::make($request->password);
            $user->phone =  $request->phone;
            $user->roles_name =  $request->roles_name;
            $user->role_id =  $role_id;
            $user->status = $request->status;
            $user->save();
            $user->assignRole($request->roles_name);



            if(isset($request->dep_no))
            {
                $UserDepartments = new UserDepartment();
                $UserDepartments->dep_id = $request->dep_no;
                $UserDepartments->user_id = $user->id;
                $UserDepartments->date = date('Y-m-d');
                $UserDepartments->save();
               
                // $user->departments()->attach(
                //     $request->dep_no,
                //     ['date'=> date('Y-m-d')]
                // );
              
            }
    
            DB::commit();
            Toastr::success('message', 'Users created successfully.');
            return redirect()->route('admin.users.index');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    }

    /*** 
     * Display the specified resource.
     * **
     *  @param  int  $id* 
     * @return \Illuminate\Http\Response
     * */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }
    /*** 
     * Show the form for editing the specified resource.
     * **
     *  @param  int  $id* @return \Illuminate\Http\Response
     * 
     * */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('id','<>',1)->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $userStatus = $user->user_status->pluck('name','id');
        $status = UserStatu::pluck('name','id')->all();
        return view('admin.users.edit',compact('user','roles','userRole','userStatus','status'));
    }
    /*** 
     * Update the specified resource in storage.
     * ** 
     * @param  \Illuminate\Http\Request  $request* 
     * @param  int  $id* @return \Illuminate\Http\Response
     * */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles_name' => 'required'
        ]);

       

        $input = $request->all();
        if(!empty($input['password']))
        {
            $input['password'] = Hash::make($input['password']);
        }
        else{
            $input = array_except($input,array('password'));
        }
        $user = User::find($id);$user->update($input);

        $role_id = UserType::where('roles_name',$request->roles_name)->value('id');
        $user = User::find($id);
        $user->update(['role_id'=>$role_id]);

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles_name'));

        Toastr::success('message', 'User updated successfully.');
        return redirect()->route('admin.users.index');

    }
    /***
     *  Remove the specified resource from storage.
     * **
     *  @param  int  $id* 
     * @return \Illuminate\Http\Response
     * */
    public function destroy(Request $request)
    {
        
        User::find($request->user_id)->delete();
        return redirect()->route('admin.users.index')
        ->with('success','User deleted successfully');
    }

    public function getPermissions($id)
    {
        $list_permission = UserType::where("id", 1)->pluck("Name","id");

        return $list_permission;
    }

    public function getclasses($id)
    {
        $list_classes = UserType::where("roles_name", $id)->pluck("Name", "id");

        return $list_classes;
    }

    public function getUserType($id)
    {
        $listSchools = ['school_assistant','Director_Control_of_School','Librarian','Accounts_manager','school_visitor'];
        $listGovernances = ['governances_assistant','Director_Control_of_governances'];
        $listDirectorates = ['directorate_assistant','Director_Control_of_directorate'];

        if ($id == 'school') 
        {
            $listUserType = UserType::whereIn("roles_name", $listSchools)->pluck("Name", "roles_name");
            // $listUserType = Role::whereIn("name", $listSchools)->pluck("name", "name");
        }
        elseif ($id == 'directorate') 
        {
            $listUserType = UserType::whereIn("roles_name", $listDirectorates)->pluck("Name","roles_name");
        }
        elseif ($id == 'governances') 
        {
            $listUserType = UserType::whereIn("roles_name", $listGovernances)->pluck("Name", "roles_name");
        }
        else 
        {
            $listUserType = UserType::where("roles_name", $id)->pluck("Name", "roles_name");
        }
       
        return $listUserType;
    }

}
