<?php

namespace App\Filament\Resources\Employees\Schemas;
use Filament\Schemas\Schema;
use App\Models\Department;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                textInput::make('employee_no')
                    ->label('Employee Number')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                textInput::make('full_name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),
                textInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                textInput::make('phone_number')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(20),
                select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->required(),
                select::make('office_id')
                    ->label('Office')
                    ->relationship('office', 'office_name')
                    ->required(),
                textInput::make('job_title')
                    ->label('Job Title')
                    ->required()
                    ->maxLength(255),
                fileUpload::make('profile_photo')
                    ->label('Profile Picture')
                    ->image()
                    ->maxSize(1024)
                    ->directory('profile_photos'),
                datePicker::make('employment_date')
                    ->label('Employment Date')
                    ->required(),
                toggle::make        ('is_active')
                    ->label('Is Active')
                    ->default(true),

            ]);
    }
}
