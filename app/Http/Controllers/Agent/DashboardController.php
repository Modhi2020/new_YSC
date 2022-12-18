<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Mail\Contact;
use Carbon\Carbon;
use App\Models\Property;
use App\Models\Message;
use App\Models\User;
use Auth;
use Hash;
use Toastr;
use App\Traits\AttachFilesTrait;

class DashboardController extends Controller
{
    use AttachFilesTrait;

    public function index()
    {
        $properties    = Property::latest()->where('agent_id', Auth::id())->take(5)->get();
        $propertytotal = Property::latest()->where('agent_id', Auth::id())->count();

        $messages      = Message::latest()->where('agent_id', Auth::id())->take(5)->get();
        $messagetotal  = Message::latest()->where('agent_id', Auth::id())->count();

        return view('agent.dashboard',compact('properties','propertytotal','messages','messagetotal'));
    }

    public function profile()
    {
        $profile = Auth::user();

        return view('agent.profile',compact('profile'));
    }
    public function profileUpdate(Request $request)
    {
       
        // $request->validate([
        //     'name'      => 'required',
        //     'username'  => 'required',
        //     'email'     => 'required|email',
        //     'image'     => 'image|mimes:jpeg,jpg,png',
        //     'about'     => 'max:250'
        // ]);

        $user = User::find(Auth::id());

        $image = $request->file('image');
        $slug  = str_slug($request->name_en);

      
        if ($request->hasFile('image')) 
        {
            $file = $request->file('image');
            $folder = $request->folder;
            $date = date('Y-m-d');
            $name = $date . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
            $imagename = $name;
            $path = 'attachments/'.$folder.'/'.$slug.'/images';

        }
        else
        {
            $imagename = $user->image;
            $path = $user->path;
        }



        $user->image = $imagename;
        $user->path = $path;
        $user->about = $request->about;

        $user->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $user->username = ['en' => $request->username_en, 'ar' => $request->username_ar];
        $user->email =  $request->email;
        $user->phone =  $request->phone;
        $user->save();

        Toastr::success('تم الحفظ بنجاح', 'حفظ');
        return redirect()->back();
    }


    
    public function changePassword()
    {
        return view('agent.changepassword');

    }

    public function changePasswordUpdate(Request $request)
    {
        if (!(Hash::check($request->get('currentpassword'), Auth::user()->password))) {

            Toastr::error('message', 'Your current password does not matches with the password you provided! Please try again.');
            return redirect()->back();
        }
        if(strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0){

            Toastr::error('message', 'New Password cannot be same as your current password! Please choose a different password.');
            return redirect()->back();
        }

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('newpassword'));
        $user->save();

      

        Toastr::success('تم الحفظ بنجاح', 'حفظ');
        return redirect()->back();
    }



    // MESSAGE
    public function message()
    {
        $messages = Message::latest()->where('agent_id', Auth::id())->paginate(10);

        return view('agent.messages.index',compact('messages'));
    }

    public function messageRead($id)
    {
        $message = Message::findOrFail($id);

        return view('agent.messages.read',compact('message'));
    }

    public function messageReplay($id)
    {
        $message = Message::findOrFail($id);

        return view('agent.messages.replay',compact('message'));
    }

    public function messageSend(Request $request)
    {
        $request->validate([
            'agent_id'  => 'required',
            'user_id'   => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        Message::create($request->all());

        Toastr::success('message', 'Message send successfully.');
        return back();

    }

    public function messageReadUnread(Request $request)
    {
        $status = $request->status;
        $msgid  = $request->messageid;

        if($status){
            $status = 0;
        }else{
            $status = 1;
        }

        $message = Message::findOrFail($msgid);
        $message->status = $status;
        $message->save();

        return redirect()->route('agent.message');
    }

    public function messageDelete($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        Toastr::success('message', 'Message deleted successfully.');
        return back();
    }


    public function contactMail(Request $request)
    {
        $message  = $request->message;
        $name     = $request->name;
        $mailfrom = $request->mailfrom;

        Mail::to($request->email)->send(new Contact($message,$name,$mailfrom));

        Toastr::success('message', 'Mail send successfully.');
        return back();
    }

}