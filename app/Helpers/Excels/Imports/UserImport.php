<?php

namespace App\Helpers\Excels\Imports;

use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{

    public function model(array $row): User
    {
        return new User([
            'name' => $row[0],
            'email' => $row[1],
        ]);
    }
    public function rules(): array
    {
        return [
            //
        ];
    }
    public function messages(): array
    {
        return [
            //
        ];
    }
}
