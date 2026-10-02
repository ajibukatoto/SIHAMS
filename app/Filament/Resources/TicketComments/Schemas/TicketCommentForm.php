<?php

namespace App\Filament\Resources\TicketComments\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Comment')
                    ->description(
                        'Add a comment to a help desk ticket.'
                    )
                    ->schema([
                        Select::make('help_desk_ticket_id')
                            ->label('Help Desk Ticket')
                            ->relationship(
                                name: 'ticket',
                                titleAttribute: 'ticket_number'
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make('comment')
                            ->label('Comment')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),

                        Toggle::make('is_internal')
                            ->label('Internal Comment')
                            ->helperText(
                                'Internal comments are visible only to authorized ICT staff.'
                            )
                            ->default(false)
                            ->visible(
                                fn (): bool =>
                                    self::canCreateInternalComment()
                            )
                            ->dehydrated(),
                    ])
                    ->columns(2),
            ]);
    }

    private static function canCreateInternalComment(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where(
                'model_has_roles.model_id',
                $user->id
            )
            ->where(
                'model_has_roles.model_type',
                User::class
            )
            ->whereIn(
                'roles.name',
                [
                    'Super Admin',
                    'ICT Manager',
                    'ICT Technician',
                ]
            )
            ->exists();
    }
}
