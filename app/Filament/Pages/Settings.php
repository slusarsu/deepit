<?php

namespace App\Filament\Pages;

use AllowDynamicProperties;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Spatie\Valuestore\Valuestore;

#[AllowDynamicProperties] class Settings extends Page
{
    protected static ?string $navigationGroup = 'System';
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $view = 'filament.pages.settings';

    protected static ?int $navigationSort = 4;

    protected Valuestore $valueStore;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->valueStore = siteSetting();
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->valueStore->get('name'),
            'author' => $this->valueStore->get('author'),
            'seoTitle' => $this->valueStore->get('seoTitle'),
            'seoKeyWords' => $this->valueStore->get('seoKeyWords'),
            'seoDescription' => $this->valueStore->get('seoDescription'),
            'isEnabled' => $this->valueStore->get('isEnabled') ?? true,
            'paginationCount' => $this->valueStore->get('paginationCount') ?? 10,
            'googleTagManager' => $this->valueStore->get('googleTagManager'),
            'metaPixelCode' => $this->valueStore->get('metaPixelCode'),
            'customHeaderCode' => $this->valueStore->get('customHeaderCode'),
            'customFooterCode' => $this->valueStore->get('customFooterCode'),
            'customCss' => $this->valueStore->get('customCss'),
            'logo' => $this->valueStore->get('logo'),
            'footerLogo' => $this->valueStore->get('footerLogo'),
            'email' => $this->valueStore->get('email'),
            'copyright' => $this->valueStore->get('copyright'),
            'textLogo' => $this->valueStore->get('isTextLogo') ?? false,
        ]);
    }

    protected function getFormSchema(): array
    {

        return [
            Tabs::make('Heading')
                ->tabs([
                    Tab::make('Site settings')
                        ->schema([
                            TextInput::make('name'),

                            FileUpload::make('logo')
                                ->directory('logo')
                                ->image(),

                            FileUpload::make('footerLogo')
                                ->directory('logo')
                                ->image(),

                            Toggle::make('isTextLogo')
                                ->default(true),

                            TextInput::make('email')->email(true),

                            TextInput::make('copyright'),

                            Toggle::make('isEnabled')
                                ->default(true),
                        ]),
                    Tab::make('SEO')
                        ->schema([
                            TextInput::make('author'),
                            TextInput::make('seoTitle'),
                            TextInput::make('seoKeyWords'),
                            Textarea::make('seoDescription'),
                            CodeField::make('googleTagManager')
                                ->htmlField()
                                ->withLineNumbers(),
                            CodeField::make('metaPixelCode')
                                ->htmlField()
                                ->withLineNumbers(),
                        ]),
                    Tab::make('Content')
                        ->schema([
                            TextInput::make('paginationCount')
                                ->integer(true)
                                ->default(9),
                        ]),
                    Tab::make('Customization')
                        ->schema([
                            CodeField::make('customHeaderCode')
                                ->htmlField()
                                ->withLineNumbers(),
                            CodeField::make('customFooterCode')
                                ->htmlField()
                                ->withLineNumbers(),
                        ]),
                    Tab::make('Custom Style')
                        ->schema([
                            CodeField::make('customCss')
                                ->cssField()
                                ->withLineNumbers(),
                        ]),
                ]),
        ];

    }

    public function submit(): void
    {

        $result = $this->form->getState();

        foreach ($result as $field => $value) {
            $this->valueStore->put($field, $value);
        }

        Artisan::call('optimize:clear');

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-sparkles')
            ->iconColor('success')
            ->send();
    }

    protected function getActions(): array
    {
        return [

            Action::make('Clear Cache')
                ->action(function () {
                    Artisan::call('optimize:clear');

                    Notification::make()
                        ->title('Fixed!')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('success'),

            ActionGroup::make([
                Action::make('Add Demo')
                    ->action(function () {
                        Artisan::call('adm:demo');

                        Notification::make()
                            ->title('Added demo data')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),

                Action::make('Remove Demo')
                    ->action(function () {
                        Artisan::call('adm:demo-remove');

                        Notification::make()
                            ->title('Removed demo data')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
            ])->label('Demo Data')->color('danger'),
        ];
    }

}
