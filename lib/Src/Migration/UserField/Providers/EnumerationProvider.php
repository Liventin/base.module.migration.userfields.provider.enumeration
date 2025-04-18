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

    public function afterAdd(int $fieldId, array $field, string $moduleId): void
    {
        if (empty($this->enumValues)) {
            return;
        }

        $enum = new CUserFieldEnum();
        $enumData = [];
        foreach ($this->enumValues as $enumValue) {
            $enumData[] = $enumValue->getElementToArray();
        }
        $enum->SetEnumValues($fieldId, $enumData);
    }

    public function getParamsToArray(): array
    {
        $enumValues = [];
        foreach ($this->enumValues as $enumValue) {
            $enumValues[] = $enumValue->getElementToArray();
        }

        return array_merge(parent::getParamsToArray(), [
            'ENUM_VALUES' => $enumValues,
        ]);
    }
}
