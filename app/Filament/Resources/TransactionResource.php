<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Room;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')->required(),
                DatePicker::make('transaction_date')->required(),
                Select::make('payment_method')
                    ->options([
                        'down_payment' => 'Down Payment',
                        'full_payment' => 'Full Payment',
                    ])->required()->reactive(),
                TextInput::make('duration')->numeric()->minValue('1')->required()->reactive()->default(1),
                Select::make('boarding_house_id')->required()
                    ->relationship('boardingHouse', 'name')
                    ->preload()
                    ->searchable()
                    ->reactive(),
                Select::make('room_id')->required()
                    ->relationship('room', 'name')
                    ->reactive()
                    ->preload()
                    ->searchable()
                    ->options(function (callable $get) {
                        $boardingHouseId = $get('boarding_house_id');

                        if (!$boardingHouseId) {
                            return [];
                        }

                        return Room::where('boarding_house_id', $boardingHouseId)->pluck('name', 'id');
                    })
                    ->afterStateUpdated(function (callable $get, callable $set, $state) {
                        $room = Room::find($state);
                        $pm = $get('payment_method');
                        if ($room->price_per_month && $pm === "down_payment") {
                            $price = $room->price_per_month * $get('duration') / 2;
                            $total = $price + (0.12 * $price);
                            $set('total_amount', ceil($total));
                        } elseif ($room->price_per_month && $pm === "full_payment") {
                            $price = $room->price_per_month * $get('duration');
                            $total = $price + (0.12 * $price);
                            $set('total_amount', ceil($total));
                        } else {
                            $set('total_amount', 0);
                        }
                    }),
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('phone_number')->required(),
                Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ])->required(),
                DatePicker::make('start_date')->required(),
                TextInput::make('total_amount')->reactive()->numeric()->prefix('Rp ')->minValue(0)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code'),
                TextColumn::make('boardingHouse.name'),
                TextColumn::make('room.name'),
                TextColumn::make('payment_method'),
                TextColumn::make('payment_status'),
                TextColumn::make('total_amount'),
                TextColumn::make('transaction_date'),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
