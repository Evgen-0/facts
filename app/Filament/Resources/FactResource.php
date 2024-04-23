<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FactResource\Pages;
use App\Filament\Resources\FactResource\RelationManagers\CollectionsRelationManager;
use App\Filament\Resources\FactResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\FactResource\RelationManagers\LikesRelationManager;
use App\Filament\Resources\FactResource\RelationManagers\TagsRelationManager;
use App\Models\Category;
use App\Models\Fact;
use App\Models\User;
use App\Services\ImageHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FactResource extends Resource
{
    protected static ?string $model = Fact::class;

    protected static ?string $label = 'Факти';

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

    public static function form(Form $form): Form
    {
        $path = Str::random() . '.png';
        return $form
            ->schema([
                Forms\Components\Section::make('Дані про факт')
                    ->schema([
                        Forms\Components\TextInput::make('heading')
                            ->label('Заголовок')
                            ->live()
                            ->afterStateUpdated(fn(Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->required()
                            ->maxLength(128),
                        Forms\Components\TextInput::make('slug')
                            ->unique(ignorable: fn() => $form->getRecord())
                            ->required()
                            ->maxLength(128),
                        Forms\Components\Select::make('user_id')
                            ->label('Користувач що додав')
                            ->options(User::orderByRaw("CASE WHEN name = 'Humor' THEN 1 WHEN name = 'Memes' THEN 2 WHEN name = 'Wtf' THEN 3 ELSE 4 END, id")->limit(15)->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->label('Категорія')
                            ->options(Category::limit(15)->pluck('name', 'id')->toArray())
                            ->searchable(),
                    ])
                    ->columns(),
                Forms\Components\Section::make('Створити факт')
                    ->schema([
                        Forms\Components\MarkdownEditor::make('content')
                            ->label('Тіло')
                            ->columnSpan('full')
                            ->dehydrated(false),
                        Forms\Components\Select::make('font')
                            ->label('Шрифт')
                            ->options([
                                'Arial' => [
                                    'fonts/arial/arial.ttf' => 'Arial',
                                    'fonts/arial/arial_bold.ttf' => 'Arial Bold',
                                    'fonts/arial/arial_light.ttf' => 'Arial Light',
                                    'fonts/arial/arial_narrow.ttf' => 'Arial Narrow',
                                ],
                                'Comic Sans MS' => [
                                    'fonts/comic_sans_ms/comic_sans_ms.ttf' => 'Comic Sans MS',
                                ],
                                'Dancing Script' => [
                                    'fonts/dancing_script/static/DancingScript-Bold.ttf' => 'Dancing Script Bold',
                                    'fonts/dancing_script/static/DancingScript-Medium.ttf' => 'Dancing Script Medium',
                                    'fonts/dancing_script/static/DancingScript-Regular.ttf' => 'Dancing Script Regular',
                                    'fonts/dancing_script/static/DancingScript-SemiBold.ttf' => 'Dancing Script SemiBold',
                                ],
                                'Helveticaing' => [
                                    'fonts/helveticaing/Helveticaing.otf' => 'Helveticaing',
                                ],
                                'Impact' => [
                                    'fonts/impact-font/impact.ttf' => 'Impact',
                                    'fonts/impact-font/Impacted.ttf' => 'Impacted',
                                    'fonts/impact-font/unicode.impact.ttf' => 'Unicode Impact',
                                ],
                                'Montserrat' => [
                                    'fonts/Montserrat/static/Montserrat-Black.ttf' => 'Montserrat Black',
                                    'fonts/Montserrat/static/Montserrat-BlackItalic.ttf' => 'Montserrat Black Italic',
                                    'fonts/Montserrat/static/Montserrat-Bold.ttf' => 'Montserrat Bold',
                                    'fonts/Montserrat/static/Montserrat-BoldItalic.ttf' => 'Montserrat Bold Italic',
                                    'fonts/Montserrat/static/Montserrat-ExtraBold.ttf' => 'Montserrat Extra Bold',
                                    'fonts/Montserrat/static/Montserrat-ExtraBoldItalic.ttf' => 'Montserrat Extra Bold Italic',
                                    'fonts/Montserrat/static/Montserrat-ExtraLight.ttf' => 'Montserrat Extra Light',
                                    'fonts/Montserrat/static/Montserrat-ExtraLightItalic.ttf' => 'Montserrat Extra Light Italic',
                                    'fonts/Montserrat/static/Montserrat-Italic.ttf' => 'Montserrat Italic',
                                    'fonts/Montserrat/static/Montserrat-Light.ttf' => 'Montserrat Light',
                                    'fonts/Montserrat/static/Montserrat-LightItalic.ttf' => 'Montserrat Light Italic',
                                    'fonts/Montserrat/static/Montserrat-Medium.ttf' => 'Montserrat Medium',
                                    'fonts/Montserrat/static/Montserrat-MediumItalic.ttf' => 'Montserrat Medium Italic',
                                    'fonts/Montserrat/static/Montserrat-Regular.ttf' => 'Montserrat Regular',
                                    'fonts/Montserrat/static/Montserrat-SemiBold.ttf' => 'Montserrat Semi Bold',
                                    'fonts/Montserrat/static/Montserrat-SemiBoldItalic.ttf' => 'Montserrat Semi Bold Italic',
                                    'fonts/Montserrat/static/Montserrat-Thin.ttf' => 'Montserrat Thin',
                                    'fonts/Montserrat/static/Montserrat-ThinItalic.ttf' => 'Montserrat Thin Italic',
                                ],
                            ])
                            ->default('fonts/impact-font/impact.ttf')
                            ->selectablePlaceholder(false)
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('fontSize')
                            ->label('Розмір шрифту')
                            ->numeric()
                            ->default(24)
                            ->requiredWith(['image', 'position', 'generate'])
                            ->dehydrated(false),
                        Forms\Components\Select::make('position')
                            ->label('Зверху/Знизу')
                            ->options([
                                'top' => 'Зверху',
                                'bottom' => 'Знизу',
                            ])
                            ->default('top')
                            ->selectablePlaceholder(false)
                            ->dehydrated(false),
                        Forms\Components\ColorPicker::make('hsl_color')
                            ->label('Колір тексту')
                            ->default('#000000')
                            ->dehydrated(false),
                        Forms\Components\FileUpload::make('body')
                            ->label('Картинка')
                            ->required()
                            ->live()
                            ->image()
                            ->acceptedFileTypes(['image/png'])
                            ->imageEditor(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('generate')
                                ->label('Згенерувати')
                                ->action(function (Set $set, $state) use ($path) {
                                    ImageHelper::createImage($state, $path);
                                }),
                            Forms\Components\Actions\Action::make('print')
                                ->label('Показати')
                                ->link()
                                ->url(config('APP_URL') . '/storage/image/temp/' . $path, true),
                            Forms\Components\Actions\Action::make('save')
                                ->label('Зберегти')
                                ->action(function (Set $set, $state) use ($path) {
                                    ImageHelper::createImage($state, $path);
                                    $temporaryUploadedFile = new TemporaryUploadedFile($path, config()->get('FILESYSTEM_DISK'));
                                    return $set('body', [Str::uuid()->toString() => $temporaryUploadedFile]);
                                }),

                        ])
                            ->alignCenter()
                            ->columnSpan('full'),
                    ])
                    ->columns()
                    ->hidden(fn(string $operation) => !($operation === 'create')),
                Forms\Components\Section::make('Картинка')
                    ->schema([
                        Forms\Components\FileUpload::make('body')
                            ->label('Картинка')
                            ->image()
                            ->columnSpan('full')
                            ->dehydrated(fn(string $operation) => !($operation === 'create')),
                    ])
                    ->hidden(fn(string $operation) => $operation === 'create')
                    ->collapsible()
                    ->collapsed(),
                Forms\Components\Section::make('Мета-дані')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Мета заголовок')
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(128),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Мета опис')
                            ->columnSpan('full')
                            ->maxLength(256),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('body')
                    ->label('Картинка'),
                Tables\Columns\TextColumn::make('heading')
                    ->label('Заголовок')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категорія'),
                Tables\Columns\TextColumn::make('stat.views')
                    ->label('Переглядів')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stat.likes')
                    ->label('Лайків')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stat.comments')
                    ->label('Коментарів')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Мета заголовок')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Мета опис')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->markdown()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
            CollectionsRelationManager::class,
            CommentsRelationManager::class,
            LikesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacts::route('/'),
            'create' => Pages\CreateFact::route('/create'),
            'edit' => Pages\EditFact::route('/{record}/edit'),
        ];
    }
}
