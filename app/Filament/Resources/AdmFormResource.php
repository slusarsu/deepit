<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdmFormResource\Pages;
use App\Filament\Resources\AdmFormResource\RelationManagers;
use App\Models\AdmForm;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction as CopyActionTable;

class AdmFormResource extends Resource
{
    protected static ?string $model = AdmForm::class;

    protected static ?string $navigationGroup = 'Tools';

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make('Form Configuration')->schema([
                        TextInput::make('title')
                            ->required()
                            ->lazy()
                            ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->required()
                            ->unique(self::getModel(), 'slug', ignoreRecord: true),


                    ])->collapsible(),

                    Section::make('Add Form Fields')
                        ->schema([
                            Repeater::make('fields')
                                ->schema([
                                    TextInput::make('field_name')
                                        ->required(),
                                ])
                                ->collapsible()
                        ])
                        ->collapsed()
                        ->collapsible(),


                ])->columnSpan(3),

                Group::make()->schema([

                    Card::make()
                        ->schema([
                            TextInput::make('link_hash')
                                ->disabled()
                                ->default(Str::random(15))
                                ->suffixAction(CopyAction::make()),

                            Toggle::make('is_enabled')
                                ->default(true),

                            Toggle::make('send_notify')
                                ->default(true),
                        ]),
                ])
                ->columnSpan(1),

            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug'),
                TextColumn::make('link_hash')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                CopyActionTable::make()
                    ->label('Copy Hash')
                    ->copyable(fn ($record) => $record->link_hash),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AdmFormItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmForms::route('/'),
            'create' => Pages\CreateAdmForm::route('/create'),
            'edit' => Pages\EditAdmForm::route('/{record}/edit'),
        ];
    }
}
