<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;

class UserInformationController extends Controller
{
    public function addInfo(Request $request) 
    {
        $fields = $request->validate([
            'credential_title' => "required",
            'credential_description' => "required"
        ]);

        if ($request->input('is_file')) {
            $fields['credential_description'] = $request->file('credential_description')->getMimeType(). ':' .base64_encode(file_get_contents($request->file('credential_description')));
        }

        UserInformation::create([
            'user_id' => auth()->user()->id,
            'credential_title' => $fields['credential_title'],
            'credential_description' => $fields['credential_description'],
            'is_file' => $request->input('is_file'),
        ]);

        return response([
            'message' => "User info added successfully"
        ]);
    }

    public function getUserInfo($userId) 
    {
        $user = User::findOrFail($userId);
        $userInfo = UserInformation::where('user_id', $userId);
        
        return response([
            'user' => $user->get()->toArray(),
            'user_info' => $userInfo->get()->toArray()
        ], 200);
    }

    public function patchInfo($userInfoId, Request $request) 
    {
        $fields = $request->validate([
            'credential_title' => "required",
            'credential_description' => "required"
        ]);

        if ($request->input('is_file')) {
            $fields['credential_description'] = $request->file('credential_description')->getMimeType(). ':' .base64_encode(file_get_contents($request->file('credential_description')));
        }

        $userInfo = UserInformation::findOrFail($userInfoId);

        $userInfo->credential_title = $fields['credential_title'];
        $userInfo->credential_description = $fields['credential_description'];
        $userInfo->is_file = $request->input('is_file');

        $userInfo->save();

        return response([
            'message' => "User info updated successfully"
        ]);
    }

    public function deleteInfo($userInfoId, Request $request) 
    {
        UserInformation::findOrFail($userInfoId)->delete();

        return response([
            'message' => "User info removed successfully"
        ]);
    }
}
