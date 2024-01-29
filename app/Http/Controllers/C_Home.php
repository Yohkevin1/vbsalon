<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;

class C_Home extends Controller
{
    public function index()
    {
        $produck = Produk::all();
        $service = Jasa::all();
        $data = [
            'service' => $service,
            'produk' => $produck,
        ];
        return view('home', compact('data'));
    }

    public function sendEmail(Request $request)
    {
        $data = [
            'name' => $request->input('Name'),
            'email' => $request->input('Email'),
            'phone' => $request->input('Phone_Number'),
            'subject' => $request->input('Subject'),
            'message' => $request->input('Message'),
        ];

        Mail::to('yohkevinwu@gmail.com')->send(new sendMail($data));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
