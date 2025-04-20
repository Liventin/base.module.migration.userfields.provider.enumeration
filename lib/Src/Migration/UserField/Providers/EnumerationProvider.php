<?php

namespace Base\Module\Src\Migration\UserField\Providers;

use Base\Module\Src\Migration\UserField\EnumValue;
use Base\Module\Src\Migration\UserField\Interface\UserFieldProvider;
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

    /**
     * @param int $fieldId
     * @param array $field
     * @param string $moduleId
     * @return void
     */
    public function afterAdd(int $fieldId, array $field, string $moduleId): void
    {
        if (empty($this->enumValues)) {
            return;
        }

        $enum = new CUserFieldEnum();
        $enumData = [];
        $count = 0;
        foreach ($this->enumValues as $enumValue) {
            $enumData['n' . $count++] = $enumValue->getElementToArray();
        }
        $enum->SetEnumValues($fieldId, $enumData);
    }

    /**
     * Возвращает параметры провайдера в виде массива.
     *
     * @return array
     */
    public function getParamsToArray(): array
    {
        return array_merge(parent::getParamsToArray(), [
            'SETTINGS' => $this->settings,
        ]);
    }
}
