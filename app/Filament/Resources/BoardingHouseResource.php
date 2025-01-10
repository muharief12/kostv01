<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('General information')
                            ->schema([
                                FileUpload::make('thumbnail')->required()->image()->directory('boarding_houses'),
                                Select::make('city_id')->relationship('city', 'name')->required(),
                                Select::make('category_id')->relationship('category', 'name')->required(),
                                TextInput::make('name')->required(),
                                TextInput::make('price')->required()->prefix('Rp')->numeric(),
                                RichEditor::make('description')->required(),
                                RichEditor::make('address')->required(),

                            ]),
                        Tab::make('Bonuses')
                            ->schema([
                                Repeater::make('bonuses')
                                    ->relationship('bonuses')
                                    ->schema([
                                        FileUpload::make('image')->required()->image()->directory('bonuses'),
                                        TextInput::make('name')->required(),
                                        RichEditor::make('description')->required(),
                                    ]),
                            ]),
                        Tab::make('Room Availability')
                            ->schema([
                                Repeater::make('rooms')
                                    ->relationship('rooms')
                                    ->schema([
                                        TextInput::make(('name'))->required(),
                                        TextInput::make(('room_type'))->required(),
                                        TextInput::make(('square_feet'))->required()->numeric(),
                                        TextInput::make(('price_per_month'))->required()->numeric()->prefix('Rp'),
                                        Toggle::make('is_available')->required(),
                                        Repeater::make('images')
                                            ->relationship('roomImages')
                                            ->schema([
                                                FileUpload::make('image')->required()->image()->directory('room_images'),
                                            ])
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail'),
                TextColumn::make('name'),
                TextColumn::make('city.name'),
                TextColumn::make('category.name'),
                TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
