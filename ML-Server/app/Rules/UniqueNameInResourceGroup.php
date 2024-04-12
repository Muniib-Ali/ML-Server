<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Resource;

class UniqueNameInResourceGroup implements ValidationRule
{


    protected $resourceGroupId;

    public function __construct($resourceGroupId)
    {
        $this->resourceGroupId = $resourceGroupId;
    }

    public function validate($attribute, $value, $fail): void
    {
        if (Resource::where('name', $value)
            ->where('resource_group_id', $this->resourceGroupId)
            ->exists()
        ) {
            $fail('A resource with this name already exists in the group.');
        }
    }
}
