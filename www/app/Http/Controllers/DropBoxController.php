<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Http;

class DropBoxController extends Controller
{
    use ValidatesRequests;

    public function dropBoxHome()
    {
        return view('pages/dropbox_form');
    }

    public function dropBoxUpload(Request $request)
    {
        // validate
        $request->validate([
            'image' => ['required', 'image', "max:15360"],
        ]);

        // do dropbox stuff
        $image = $request->file('image');
        $imageFileName = '/'.time().rand(1000, 9990).'.'.$image->getClientOriginalExtension();

        $dropbox = Storage::disk('dropbox');
        $path = 'Apps/Gogeruk_private_ap';
        $dropbox->write($path.$imageFileName, $image);

        //temp url
        $dropbox_url = 'https://api.dropboxapi.com/2/files/get_temporary_link';

        $tmp_url_req = Http::withHeaders([
            'Authorization' => 'Bearer '.env('DROPBOX_TOKEN')
        ])->post($dropbox_url, [
            'path' => '/'.$path.$imageFileName
        ]);

        $tmp_url = json_decode($tmp_url_req->body(), true)['link'];

        // return link
        return view('pages/dropbox_form', [
            'status' => $tmp_url
        ]);
    }
}
