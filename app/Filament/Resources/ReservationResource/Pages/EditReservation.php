<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Mail\ReservationApproved;
use App\Mail\ReservationDeclined;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EditReservation extends EditRecord
{

    
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();

        // Eğer statü alanı doldurulmamışsa veya email yoksa işlemi durdur
        if (!$record->status || !$record->email) {
            return;
        }

        try {
            // DURUM 1: ONAYLANDIYSA
            if ($record->status === 'approved') {
                Mail::to($record->email)->send(new ReservationApproved($record));

                Notification::make()
                    ->title('Onay Maili Gönderildi')
                    ->body('Müşteriye rezervasyon onayı iletildi.')
                    ->success()
                    ->send();
            }
            
            // DURUM 2: REDDEDİLDİYSE
            // Veritabanındaki değerin tam olarak 'declined' olduğundan emin olun
            elseif ($record->status === 'declined') {
                Mail::to($record->email)->send(new ReservationDeclined($record));

                Notification::make()
                    ->title('Ret Maili Gönderildi')
                    ->body('Müşteriye ret mesajı başarıyla iletildi.')
                    ->danger()
                    ->send();
            }

        } catch (\Exception $e) {
            // Gerçek hatayı loglara yazalım ki sorunu kökten görebilelim
            Log::error('Mail Gönderim Hatası (Rezervasyon ID: ' . $record->id . '): ' . $e->getMessage());

            Notification::make()
                ->title('Mail Gönderilemedi')
                ->body('Durum güncellendi ancak mail iletilemedi. Lütfen sistem loglarını veya SMTP ayarlarını kontrol edin.')
                ->warning()
                ->persistent() // Hata mesajı ekranda kalsın
                ->send();
        }
    }
}