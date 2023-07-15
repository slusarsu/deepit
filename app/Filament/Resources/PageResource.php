<?php

namespace App\Filament\Resources;

use App\Adm\Services\PageService;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\Widgets\PageStatsOverview;
use App\Models\Page;
use Filament\Forms\Components\Builder as FromBuilder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 1;

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
                                ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null)
                                ->columnSpanFull(),

                            TextInput::make('slug')
                                ->required()
                                ->unique(self::getModel(), 'slug', ignoreRecord: true)
                                ->columnSpanFull(),

                            TinyEditor::make('short')
                                ->fileAttachmentsDisk('local')
                                ->fileAttachmentsVisibility('storage')
                                ->fileAttachmentsDirectory('public/images')
                                ->setConvertUrls(false)
                        ]),

                    Section::make('Content')
                        ->schema([
                            TinyEditor::make('content')
                                ->fileAttachmentsDisk('local')
                                ->fileAttachmentsVisibility('storage')
                                ->fileAttachmentsDirectory('public/images')
                                ->setConvertUrls(false)
                        ]),

                    Tabs::make('Heading')
                        ->tabs([
                            Tab::make('Images')
                                ->icon('heroicon-o-film')
                                ->schema([
                                    FileUpload::make('images')->directory('images')->multiple()->image()
                                ])  ,

                            Tab::make('Custom Fields')
                                ->icon('heroicon-o-document-text')
                                ->schema([
                                    FromBuilder::make('custom_fields')
                                        ->blocks([
                                            Block::make('text_input')
                                                ->schema([
                                                    TextInput::make('field_name'),
                                                    TextInput::make('text')
                                                ])
                                                ->label(fn (array $state): ?string => $state['field_name'] ?? null),
                                            Block::make('paragraph')
                                                ->schema([
                                                    TextInput::make('field_name'),
                                                    Textarea::make('content')
                                                        ->label('Paragraph')
                                                        ->required(),
                                                ]),
                                            Block::make('content')
                                                ->schema([
                                                    TextInput::make('field_name'),
                                                    TinyEditor::make('content')
                                                        ->fileAttachmentsDisk('local')
                                                        ->fileAttachmentsDirectory('public/images')
                                                        ->fileAttachmentsVisibility('storage')
                                                        ->setConvertUrls(false)
                                                ]),
                                            Block::make('image')
                                                ->schema([
                                                    TextInput::make('field_name'),
                                                    FileUpload::make('url')
                                                        ->label('Image')
                                                        ->directory('images')
                                                        ->image()
                                                        ->required(),
                                                    TextInput::make('alt')
                                                        ->label('Alt text')
                                                        ->required(),
                                                ]),
                                            Block::make('images')
                                                ->schema([
                                                    TextInput::make('field_name'),
                                                    FileUpload::make('url')
                                                        ->label('Image')
                                                        ->directory('images')
                                                        ->multiple()
                                                        ->image()
                                                        ->required(),
                                                ]),
                                        ])
                                ]),

                            Tab::make('SEO')
                                ->icon('heroicon-o-folder')
                                ->schema([
                                    TextInput::make('seo_title')
                                        ->columnSpan('full'),
                                    TextInput::make('seo_text_keys')
                                        ->columnSpan('full'),
                                    Textarea::make('seo_description')
                                        ->columnSpan('full'),
                                ]),
                        ]),

                ])->columnSpan(3),

                Group::make()->schema([

                    Section::make('Settings')
                        ->schema([
                            FileUpload::make('thumb')
                                ->label('Thumbnail')
                                ->directory('images')
                                ->image(),

                            Select::make('template')
                                ->options(PageService::getListOfPageTemplates())
                                ->default('page')
                                ->required(),

                            DateTimePicker::make('created_at')
                                ->default(Carbon::now()),
                            Toggle::make('is_enabled')
                                ->default(true)
                        ])->collapsible(),

                ])->columnSpan(1),
            ])->columns(4);
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

                IconColumn::make('is_enabled')
                    ->boolean(),

                TextColumn::make('template')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('only_enabled')
                    ->query(fn (Builder $query): Builder => $query->where('is_enabled', true))
                    ->toggle()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PageStatsOverview::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
