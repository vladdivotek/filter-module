<?php

namespace Modules\Filter\Admin;

use App\Filament\Resources\TranslateResource\RelationManagers\TranslatableRelationManager;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Tables\Actions\Action;
use Modules\Filter\Admin\AttributeResource\Pages;
use App\Services\Schema;
use App\Services\TableSchema;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Filter\Models\Attribute;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Category');
    }

    public static function getModelLabel(): string
    {
        return __('Attribute');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Attributes');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Schema::getName(),
                        Schema::getSorting(),
                        Schema::getImage()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableSchema::getName(),
                TableSchema::getSorting(),
                TableSchema::getImage(),
                TableSchema::getUpdatedAt()
            ])
            ->headerActions([
                Action::make(__('Help'))
                    ->iconButton()
                    ->icon('heroicon-o-question-mark-circle')
                    ->modalDescription(__('Summary'))
                    ->modalFooterActions([]),

            ])
            ->reorderable('sorting')
            ->filters([
                TableSchema::getFilterStatus(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationGroup::make('Seo and translates', [
                TranslatableRelationManager::class,
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
