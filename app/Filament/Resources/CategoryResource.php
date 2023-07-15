<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Card::make()
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                            TextInput::make('slug')
                                ->required()
                                ->unique(self::getModel(), 'slug', ignoreRecord: true),

                            TextInput::make('order')
                                ->integer(true)
                                ->default(0),

                            Select::make('parent_id')
                                ->options(function($record) {
                                    if($record) {
                                        return Category::query()
                                            ->whereNot('id', $record->id)
                                            ->pluck('title', 'id');
                                    }
                                    return Category::query()->pluck('title', 'id');
                                })
                                ->searchable(),

                            TinyEditor::make('content')
                                ->fileAttachmentsDisk('local')
                                ->fileAttachmentsVisibility('storage')
                                ->fileAttachmentsDirectory('public/images')
                                ->setConvertUrls(false)
                        ]),

                    Section::make('SEO')
                        ->schema([
                            TextInput::make('seo_title')
                                ->columnSpan('full'),
                            Textarea::make('seo_text_keys')
                                ->columnSpan('full'),
                            Textarea::make('seo_description')
                                ->columnSpan('full'),
                        ])->collapsible()->collapsed(),


                ])->columnSpan(3),

                Group::make()->schema([

                    Section::make('Thumbnail')
                        ->schema([
                            FileUpload::make('thumb')
                                ->label('Thumbnail')
                                ->directory('images')
                                ->image(),
                        ])
                        ->collapsible(),


                    Section::make('Settings')
                        ->schema([
                            DateTimePicker::make('created_at')
                                ->default(Carbon::now()),
                            Toggle::make('is_enabled')
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
                TextColumn::make('id')
                    ->sortable(),

                ImageColumn::make('thumb'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug'),

                TextColumn::make('order')
                    ->sortable(),

                TextColumn::make('parent.title')
                    ->sortable(),

                IconColumn::make('is_enabled')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->sortable()
                    ->date(),
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
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
