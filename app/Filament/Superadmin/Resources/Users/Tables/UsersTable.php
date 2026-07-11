<?php

namespace App\Filament\Superadmin\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            //set query only show users that are not superadmin
            ->query(User::query()->where('is_superadmin', false))
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('address')->sortable()->searchable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function ($state) {
                        return $state ? 'success' : 'danger';
                    })
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Aktif' : 'Nonaktif';
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('deactivate')
                    ->label('Nonaktifkan Akun')
                    ->action(function ($record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->modalDescription('Apakah anda yakin ingin menonaktifkan akun ini?, Pengguna yang dinonaktifkan tidak akan bisa login ke sistem.')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn($record) => $record->is_active),
                Action::make('activate')
                    ->label('Aktifkan Akun')
                    ->action(function ($record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->modalDescription('Apakah anda yakin ingin mengaktifkan akun ini?')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn($record) => !$record->is_active),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
