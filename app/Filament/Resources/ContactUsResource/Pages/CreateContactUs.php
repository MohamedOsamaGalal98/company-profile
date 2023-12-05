<?php

namespace App\Filament\Resources\ContactUsResource\Pages;

use App\Filament\Resources\ContactUsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Mail\ContactUsMail;
use App\Models\ContactUs;
use Filament\Forms;
use Illuminate\Support\Facades\Mail;


class CreateContactUs extends CreateRecord
{
    protected static string $resource = ContactUsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Send Email before saving to the database
        Mail::to('m.osama2798@gmail.com')->send(new ContactUsMail($data));

        return $data;
    }
}
