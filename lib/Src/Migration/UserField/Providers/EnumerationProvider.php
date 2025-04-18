<?php

namespace Base\Module\Src\Migration\UserField\Providers;

use Base\Module\Src\Migration\UserField\EnumValue;
use Base\Module\Src\Migration\UserField\Interface\UserFieldProvider;
use CUserFieldEnum;

class EnumerationProvider extends UserFieldProvider
{
    private array $enumValues = [];

    public function getType(): string
    {
        return 'enumeration';
    }

    public function createEnumValue(): EnumValue
    {
        $enumValue = new EnumValue();
        $this->enumValues[] = $enumValue;
        return $enumValue;
    }

    protected function afterAdd(int $fieldId, array $field, string $moduleId): void
    {
        if (empty($this->enumValues)) {
            return;
        }

        $enum = new CUserFieldEnum();
        $enumData = [];
        $count = 0;
        foreach ($this->enumValues as $enumValue) {
            $enumData['n'.$count++] = $enumValue->getElementToArray();
        }
        $enum->SetEnumValues($fieldId, $enumData);
    }
}
