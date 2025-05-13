<?php

namespace Base\Module\Src\Migration\UserField\Providers;

use Base\Module\Src\Migration\UserField\EnumValue;
use CUserFieldEnum;

class EnumerationProvider extends UserFieldProvider
{
    private array $enumValues = [];

    public static function getType(): string
    {
        return 'enumeration';
    }

    /**
     * @return EnumValue
     */
    public function createEnumValue(): EnumValue
    {
        $enumValue = new EnumValue();
        $this->enumValues[] = $enumValue;
        return $enumValue;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setListHeight(int $height): self
    {
        $this->settings['LIST_HEIGHT'] = max(1, $height);
        return $this;
    }

    /**
     * @param string $display
     * @return $this
     */
    public function setDisplay(string $display): self
    {
        $allowedDisplays = ['LIST', 'CHECKBOX', 'UI', 'DIALOG'];
        $this->settings['DISPLAY'] = in_array($display, $allowedDisplays) ? $display : 'LIST';
        return $this;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function setCaptionNoValue(string $caption): self
    {
        $this->settings['CAPTION_NO_VALUE'] = $caption;
        return $this;
    }

    /**
     * @param bool $showNoValue
     * @return $this
     */
    public function setShowNoValue(bool $showNoValue): self
    {
        $this->settings['SHOW_NO_VALUE'] = $showNoValue ? 'Y' : 'N';
        return $this;
    }

    public function getParamsToArray(): array
    {
        return array_merge(parent::getParamsToArray(), [
            'ENUM_VALUES_LIST' => $this->enumValues,
        ]);
    }

    /**
     * @param int $fieldId
     * @param array $field
     * @param string $moduleId
     * @return void
     */
    public function afterAdd(int $fieldId, array $field, string $moduleId): void
    {
        if (empty($field['params']['ENUM_VALUES_LIST'])) {
            return;
        }

        $enum = new CUserFieldEnum();
        $enumData = [];
        $count = 0;
        foreach ($field['params']['ENUM_VALUES_LIST'] as $enumValue) {
            $enumData['n' . $count++] = $enumValue->getElementToArray();
        }

        $enum->SetEnumValues($fieldId, $enumData);
    }
}
