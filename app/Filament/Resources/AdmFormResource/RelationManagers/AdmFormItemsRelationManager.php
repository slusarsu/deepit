<?php

namespace App\Filament\Resources\AdmFormResource\RelationManagers;

use App\Enums\AdmMailStatusEnum;
use App\Services\AdmFormService;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Novadaemon\FilamentPrettyJson\PrettyJson;

class AdmFormItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'admFormItems';

    protected static ?string $recordTitleAttribute = 'adm_form_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                TextInput::make('id')->disabled()->columnSpanFull(),
                PrettyJson::make('payload')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'primary',
                        'danger' => AdmMailStatusEnum::ERROR_SENT->value,
                        'warning' => AdmMailStatusEnum::NOT_SENT->value,
                        'success' => AdmMailStatusEnum::SENT->value,
                    ]),
                TextColumn::make('payload')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('Send')
                    ->action(fn ($record) => AdmFormService::sendEmailForItem($record))
                    ->icon('heroicon-s-paper-airplane')
                    ->requiresConfirmation(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
