<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Mail\ReservationApproved; // Onay Maili
use App\Mail\ReservationDeclined; // Ret Maili (YENİ EKLENDİ)
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

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

        // Eğer statü değişmediyse işlem yapma
        if (! $record->wasChanged('status')) {
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
            
            // DURUM 2: REDDEDİLDİYSE (YENİ)
            elseif ($record->status === 'declined') {
                Mail::to($record->email)->send(new ReservationDeclined($record));

                Notification::make()
                    ->title('Ret Maili Gönderildi')
                    ->body('Müşteriye yoğunluk nedeniyle ret maili iletildi.')
                    ->danger() // Kırmızı bildirim
                    ->send();
            }

        } catch (\Exception $e) {
            Notification::make()
                ->title('Mail Gönderilemedi')
                ->body('Durum güncellendi fakat mail hatası oluştu: ' . $e->getMessage())
                ->warning()
                ->send();
        }
    }
}