<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Article;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(Article::TITLE)->required(),
                Forms\Components\MarkdownEditor::make(Article::CONTENT)->required(),
                Forms\Components\Toggle::make(Article::IS_PUBLISHED),
                Forms\Components\Select::make('tags')
                    ->label('Tags')
                    ->multiple()
                    ->relationship('tags', Tag::NAME)
                    // 直接 preloading 出來可能會造成 memory 爆掉的問題，但目前預期 tag 只有 Admin 能新增，不太可能很多
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make(Tag::NAME)
                            ->required()
                            ->unique(table: Tag::TABLE, ignorable: fn($record) => $record),
                    ]),
                Forms\Components\Select::make('categories')
                    ->label('Categories')
                    ->multiple()
                    ->relationship('categories', Category::NAME)
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make(Category::NAME)
                            ->required()
                            ->unique(table: Category::TABLE, ignorable: fn($record) => $record),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(Article::TITLE)->limit(30),
                Tables\Columns\TextColumn::make(Tag::TABLE . '.' . Tag::NAME)->label('Tags')->badge(),
                Tables\Columns\TextColumn::make(Category::TABLE . '.' . Category::NAME)->label('Categories')->badge(),
                Tables\Columns\ToggleColumn::make(Article::IS_PUBLISHED)->sortable(),
                Tables\Columns\TextColumn::make(Article::CREATED_AT)->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
