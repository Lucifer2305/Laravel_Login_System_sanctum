<?php

namespace App\Http\Controllers;

use App\Models\contactForm;
use App\Http\Requests\StorecontactFormRequest;
use App\Http\Requests\UpdatecontactFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rules\Password as RulesPassword;

class ContactFormController extends Controller
{
    
    public function Contact(Request $request){

        $fields = $request->validate([
            'name' => 'required|string',
            'dateofbirth' => 'required|string',
            'email' => 'required|string',
            'SSN' => 'required|string'

        ]);

        $user = User::create([
            'email' =>bycrpt($fields['email']),
        ]);
    }

    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecontactFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecontactFormRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function show(contactForm $contactForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\contactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function edit(contactForm $contactForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecontactFormRequest  $request
     * @param  \App\Models\contactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecontactFormRequest $request, contactForm $contactForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(contactForm $contactForm)
    {
        //
    }
}
