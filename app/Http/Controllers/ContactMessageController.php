<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactMessageController extends Controller
{
    public function store(StoreContactMessageRequest $request): JsonResponse|RedirectResponse
    {
        if (! $request->isSpam()) {
            $this->notify(ContactMessage::create($request->validated()));
        }

        $message = "Teşekkürler {$request->string('name')}! Mesajınız bize ulaştı, en kısa sürede dönüş yapacağız.";

        return $request->expectsJson()
            ? response()->json(['message' => $message])
            : redirect()->to(url('/').'#iletisim')->with('contact_success', $message);
    }

    private function notify(ContactMessage $contactMessage): void
    {
        try {
            Mail::to(config('yaren.contact_recipient'))->send(new ContactMessageReceived($contactMessage));
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
