<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
    </head>
    <body style="font-family: sans-serif; color: #3b2418; line-height: 1.6">
        <p><strong>Ad:</strong> {{ $contactMessage->name }}</p>
        <p><strong>E-posta:</strong> {{ $contactMessage->email }}</p>
        <p><strong>Mesaj:</strong></p>
        <p style="white-space: pre-line">{{ $contactMessage->message }}</p>
    </body>
</html>
