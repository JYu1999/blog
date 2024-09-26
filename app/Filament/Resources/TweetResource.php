<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TweetResource\Pages;
use App\Models\Tag;
use App\Models\Tweet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TweetResource extends Resource
{
    protected static ?string $model = Tweet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make(Tweet::CONTENT)->required(),
                Forms\Components\Toggle::make(Tweet::IS_PUBLISHED),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(Tweet::CONTENT)->limit(30),
                Tables\Columns\TextColumn::make(Tag::TABLE . '.' . Tag::NAME)->label('Tags')->badge(),
                Tables\Columns\ToggleColumn::make(Tweet::IS_PUBLISHED)->sortable(),
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
            'index' => Pages\ListTweets::route('/'),
            'create' => Pages\CreateTweet::route('/create'),
            'edit' => Pages\EditTweet::route('/{record}/edit'),
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
