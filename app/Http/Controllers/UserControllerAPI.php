<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource as UserResource;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        return UserResource::collection(User::paginate(5));
    }
    public function show($id)
    {
        return new UserResource(User::find($id));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:3',
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }
    public function invertShift(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->shift_active) {
            $user->last_shift_end = date("Y-m-d H:i:s");
        } else {
            $user->last_shift_start = date("Y-m-d H:i:s");
        }
        $user->shift_active = !$user->shift_active;
        $user->save();
        return new UserResource($user);
    }

    public function editBlock($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = !$user->blocked;
        $user->save();
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }

    public function changePassword(Request $request, $id) {
        $request->validate([
            'old_password' => 'required|min:3',
            'new_password' => 'required|min:3',
        ]);

        $user = User::findOrFail($id);

        $check_password_match = !Hash::check($request->old_password, $user->password);
        if ($check_password_match) {
            return response()->json(array('error'=>'Password not correct.', 400));
        }

        $check_password_match = Hash::check($user->password, $request->new_password);
        if ($check_password_match) {
            return response()->json(array('error'=>'New password cannot be the same', 400));
        }

        $user->password = Hash::make($request->new_password);

        if (!$user->save()) {
            return response()->json(array('error'=>'Password change failed', 400));
        }
        
        return response()->json(array('msg'=>'Password changed sucessfully.', 200));
    }

    public function postPhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'mimes:jpeg,bmp,png',
        ]);
        if ($id != -1) {
            $user = User::find($id);
            if ($user->photo_url) {
                Storage::disk('local')->delete('public/profiles/' . $user->photo_url);
            }
        }
        $file = Input::file('file');
        //$uploadedFile="CC1".'.'."jpg";
        if (!Storage::disk('local')->put('public/profiles/' . $file, File::get($file))) {
            return response()->json([
                'message' => 'Problem uploading item photo.',
                'status' => 422,
            ], 422);
        }
        if ($id != -1) {
            $user->photo_url = $file;
            $user->save();
        }
        return response()->json(
            ['status' => 201,
                'success' => 'item photo updated.',
                'photo' => $file]);
    }
}
