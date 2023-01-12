<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class SettingController extends Controller
{
    public function index ()
    {
        $data['title']='Setting';
        $data['setting'] = Settings::first();
        return view('backend.setting.index',$data);
    }

    public function updateGeneralData(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        $this->setting = Settings::first();
        $this->setting->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
        // toast('berhasil ');
        return back();
    }

    public function updateModal(Request $request)
    {
        $request->validate([
            'modal' => 'required|numeric',
        ]);
        $this->setting = Settings::first();
        $this->setting->update([
            'modal' => $request->modal,
        ]);
        return back();
    }

    public function updateLogo(Request $request){
        $request->validate([
            'icons'=>'required|image|mimes:png,jpg,jpeg,gif',
        ]);
        $path = storage_path('app/public/icons');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path,0777,true, true);

        }
        $icons = $request->icons;
        $filename = $icons->getClientOriginalName();
        $extention = explode(".",$filename);
        $newFileName = uniqid(). "." . $extention[1];

        $logoResize = Image::make($icons->getRealPath());
        $logoResize->resize(256, 256);
        $logoResize->save(storage_path('app/public/icons/' . $newFileName));
        // $this->setting = Settings:first();
        $this->setting = Settings::first();
        if (Storage::disk('public')->exists($this->setting->icons)) {
            Storage::disk('public')->delete($this->setting->icons);
        }

        $this->setting->update([
            'icons' => 'icons/' . $newFileName
        ]);
        // toast('Logo updated','success');
        return back();
    }
}