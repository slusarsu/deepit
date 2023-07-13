<?php

namespace App\Filament\Resources;

use App\Enums\WidgetTypeEnum;
use App\Filament\Resources\ChunkResource\Pages;
use App\Filament\Resources\ChunkResource\RelationManagers;
use App\Models\Chunk;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ChunkResource extends Resource
{
    protected static ?string $model = Chunk::class;

    protected static ?string $navigationGroup = 'Tools';

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Card::make()->schema([
                        TextInput::make('title')
                            ->required()
                            ->lazy()
                            ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->columnSpanFull(),

                        Select::make('type')->options(
                            WidgetTypeEnum::allValues()
                        )->required(),

                        CodeField::make('body')
                            ->htmlField()
                            ->withLineNumbers(),

                        Toggle::make('is_enabled')->default(true),
                    ]),
                ])->columnSpan(3),

                Group::make()->schema([
                    Card::make()->schema([

                        TextInput::make('slug')
                            ->required()
                            ->unique(self::getModel(), 'slug', ignoreRecord: true)->columnSpanFull(),

                        Select::make('position')
                            ->options(
                                config('adm.chunk_positions')
                            ),

                        TextInput::make('order')
                            ->integer(true)
                            ->default(0),
                    ]),
                ])->columnSpan(1),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('type')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position')
                    ->sortable(),
                IconColumn::make('is_enabled')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('date')
                    ->date()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChunks::route('/'),
            'create' => Pages\CreateChunk::route('/create'),
            'edit' => Pages\EditChunk::route('/{record}/edit'),
        ];
    }
}
