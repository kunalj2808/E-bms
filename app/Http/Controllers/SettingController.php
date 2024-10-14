<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GeneralSetting;

class SettingController extends Controller
{
   public function index(){
    $user = User::findOrFail(1);
    return view('settings.index',compact('user'));
   }

   //general settings index page 
   public function general_setting(){
    $general = GeneralSetting::findOrFail(1);
    return view('settings.general.index',compact('general'));
   }

   public function update(Request $request, $id)
   {
       // Validate the incoming data
       $request->validate([
           'admin_email' => 'required|email',
           'company_banner' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
           'admin_image' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
       ]);
   
       // Find the user by ID
       $user = User::findOrFail($id);

   
       // Handle company banner upload
       if ($request->hasFile('company_banner')) {
           // Delete the old banner if it exists
           if ($user->company_banner) {
               $oldBannerPath = public_path('images/admin/' . $user->company_banner);
               if (file_exists($oldBannerPath)) {
                   unlink($oldBannerPath);
               }
           }
   
           // Store the new banner
           $bannerName = time() . '_banner.' . $request->company_banner->extension();
           $request->company_banner->move(public_path('images/admin'), $bannerName);
           $user->company_banner = $bannerName; // Update the user's company_banner attribute
       }
   
       // Handle admin image upload
       if ($request->hasFile('admin_image')) {
           // Delete the old image if it exists
           if ($user->admin_image) {
               $oldImagePath = public_path('images/admin/' . $user->admin_image);
               if (file_exists($oldImagePath)) {
                   unlink($oldImagePath);
               }
           }
   
           // Store the new admin image
           $imageName = time() . '_image.' . $request->admin_image->extension();
           $request->admin_image->move(public_path('images/admin'), $imageName);
           $user->admin_image = $imageName; // Update the user's admin_image attribute
       }
   
     // Update user attributes
     $updated = $user->update([
            'company_name' => $request->input('company_name'),
            'company_address' => $request->input('company_address'),
            'email' => $request->input('admin_email'),
            'name' => $request->input('name'),
            'phone_number' => $request->input('admin_number'),
            'display_name' => $request->input('display_name'),
            'designation' => $request->input('designation'),
        ]);

        // Debug: check if update was successful


   
       // Redirect with success message
       return redirect()->route('settings.index')->with('success', 'Settings details have been successfully updated.');
   }


   public function general_update(Request $request)
   {
       $validatedData = $request->validate([
        'upto_50' => 'required|numeric|min:0',
        'upto_50_150' => 'required|numeric|min:0',
        'upto_150_300' => 'required|numeric|min:0',
        'above_300' => 'required|numeric|min:0',
        'tariff_dg' => 'required|numeric|min:0',
        'service_tax_dg' => 'required|numeric|min:0',
        'electricity_upto' => 'required|numeric|min:0',
        'electicity_value' => 'required|numeric|min:0',
        'electicity_above_value' => 'required|numeric|min:0',
        'late_percentage' => 'required|numeric|min:0',
        'maintain_cost' => 'required|numeric|min:0',
        'payment_qr' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:2048',
    ]);

       // Find the user by ID
       $user = GeneralSetting::findOrFail(1);
      // Handle company banner upload
      if ($request->hasFile('payment_qr')) {
        // Delete the old banner if it exists
        if ($user->qr_image) {
            $oldBannerPath = public_path('images/admin/' . $user->qr_image);
            if (file_exists($oldBannerPath)) {
                unlink($oldBannerPath);
            }
        }

        // Store the new banner
        $qrName = time() . '_qr.' . $request->payment_qr->extension();
        $request->payment_qr->move(public_path('images/admin'), $qrName);
        $user->qr_image = $qrName; // Update the user's company_banner attribute
    }
      
     // Update genral settings attributes
     $updated = $user->update([
            'upto_50' => $request->input('upto_50'),
            'upto_50_150' => $request->input('upto_50_150'),
            'upto_150_300' => $request->input('upto_150_300'),
            'above_300' => $request->input('above_300'),
            'tariff_dg' => $request->input('tariff_dg'),
            'service_tax_dg' => $request->input('service_tax_dg'),
            'electricity_upto' => $request->input('electricity_upto'),
            'electicity_value' => $request->input('electicity_value'),
            'electicity_above_value' => $request->input('electicity_above_value'),
            'late_percentage' => $request->input('late_percentage'),
            'maintain_cost' => $request->input('maintain_cost'),
        ]);

        // Debug: check if update was successful


   
       // Redirect with success message
       return redirect()->route('settings.general')->with('success', 'Settings details have been successfully updated.');
   }
   
   
}
