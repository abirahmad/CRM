<?php

use App\Models\Contact;
use App\Models\ContactReference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact = new Contact();
        $contact->name = 'Polash Rana';
        $contact->unit_id = 1;
        $contact->email = 'polash@gmail.com';
        $contact->phone_no = '01951233084';
        $contact->office_address = 'Rajshahi';
        $contact->password = Hash::make('123456');
        $contact->api_token = str_random(100);
        $contact->contact_type_id = 3;

        $contact->district_id = 3;
        $contact->upazilla_id = 3;
        $contact->save();

        // Create Referrence
        $contactReference = new ContactReference();
        $contactReference->name = 'Mrs Zaman';
        $contactReference->relation_type_id = 11;
        $contactReference->contact_id = $contact->id;
        $contactReference->save();

        $contactReference = new ContactReference();
        $contactReference->name = 'Rahul Khan';
        $contactReference->relation_type_id = 5;
        $contactReference->contact_id = $contact->id;
        $contactReference->save();
    }
}
