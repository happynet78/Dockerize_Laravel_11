<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use SawaStacks\Utils\Library\Kropify;
use App\Models\GeneralSetting;

class AdminController extends Controller
{
    public function adminDashboard(Request $request) {
        $data = [
            'pageTitle' => 'Dashboard'
        ];

        return view('back.pages.dashboard', $data);
    }

    public function logoutHandler(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('fail', 'You are now logged out!.');
    }

    public function profileview(Request $request) {
        $data = [
            'pageTitle' => 'Profile'
        ];

        return view('back.pages.profile', $data);
    }

    public function updateProfilePicture(Request $request) {
        $user = User::findOrFail(auth()->id());
        $path = 'images/users/';
        $file = $request->file('profilePictureFile');
        $old_picture = $user->getAttributes()['picture'];
        $filename = 'IMG_'.uniqid().'.png';

        $upload = Kropify::getFile($file, $filename)->maxWoH(255)->save($path);

        if( $upload ) {
            // Delete old profile picture if exists
            if ($old_picture != null && File::exists(public_path($path.$old_picture))) {
                File::delete(public_path($path.$old_picture));
            }

            // Update Profile picture in DB
            $user->update(['picture' => $filename]);

            return response()->json(['status' => 1, 'message' => 'Your prifile picture has been updated successfully.']);
        } else {
            return response()->json(['status'=>0, 'message' => 'Something went wrong.']);
        }
    }

    public function generalSettings(Request $request) {
        $data = [
            'pageTitle' => 'General Settings'
        ];
        return view('back.pages.general_settings', $data);
    }

    public function updateLogo(Request $request) {
        $settings = GeneralSetting::take(1)->first();

        if(!is_null($settings)) {
            $path = '/images/site/';
            $old_path = $settings->site_logo;
            $file = $request->file('site_logo');
            $filename = 'logo_' . uniqid() . '.png';

            if($request->hasfile('site_logo')) {
                $upload = $file->move(public_path($path), $filename);

                if($upload) {
                    if($old_path != null && File::exists(public_path($path.$old_path))) {
                        File::delete(public_path($path.$old_path));
                    }

                    $settings->update(['site_logo'=>$filename]);

                    return response()->json(['status' => 1, 'image_path' => $path.$filename, 'message'=>'Site logo has been updated successfully.']);
                } else {
                    return response()->json(['status'=>0, 'message'=>'Something went wrong in uploading new logo.']);
                }
            }
        } else {
            return respinse()->json(['status'=>0, 'message'=>'Make sure you updated general settings form first.']);
        }
    }

    public function updateFavicon(Request $request) {
        $settings = GeneralSetting::take(1)->first();

        if( !is_null($settings) ) {
            $path = 'images/site';
            $old_path = $settings->favicon;
            $file = $request->file('site_favicon');
            $filename = 'favicon_'.uniqid().'.png';

            if( $request->hasfile('site_favicon')) {
                $upload = $file->move(public_path($path), $filename);

                if($upload) {
                    if($old_path != null && File::exists(public_path($path.$old_path))) {
                        File::delete(public_path($path.$old_path));
                    }

                    $settings->update(['site_favicon'=>$filename]);
                    return response()->json(['status' => 1, 'message' => 'Site favicon has been updated successfully.', 'image_path' => $path.$filename]);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Something went wrong in uploading new favicon.']);
                }
            }
        } else {
            return response()->json(['status'=>0, 'message'=>'Make sure you updated general settings tab first.']);
        }
    }

    public function categoriesPage(Request $request) {
        $data = [
            'pageTitle' => 'Manage categories'
        ];

        return view('back.pages.categories_page', $data);
    }
}
