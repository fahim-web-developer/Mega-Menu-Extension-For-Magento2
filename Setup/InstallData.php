<?php
namespace Fahim\MegaMenu\Setup;


use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

// use Magento\Eav\Setup\EavSetup;
// use Magento\Eav\Setup\EavSetupFactory;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);

        $groups = [
            'menu' => ['name' => 'Menu', 'code' => 'menu', 'sort' => 80, 'id' => null],
        ];

        $categorySetup->addAttributeGroup($entityTypeId, $attributeSetId, $groups['menu']['name'], $groups['menu']['sort']);
        $menuAttributeGroupId = $categorySetup->getAttributeGroupId($entityTypeId, $attributeSetId, $groups['menu']['code']);
        
        $attributes = $this->getAttributes();
        foreach($attributes as $attributeCode => $attributeProp)
        {
            $categorySetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, $attributeCode, $attributeProp);
            $categorySetup->addAttributeToGroup(
                $entityTypeId,
                $attributeSetId,
                $menuAttributeGroupId,
                $attributeCode,
                $attributeProp['sort_order']
            );
        }
    }

    protected function getAttributes()
    {
        $attributes = [

            'Fahim_menu_width_left' => [
                'group'                 => 'Menu',
                'label'                 => 'Left Block Width',
                'note'                  => "Left Block",
                'backend'               => '',
                'type'                  => 'varchar',
                'frontend'              => '',
                'input'                 => 'text',
                'user_defined'          => true,
                'required'              => false,
                'visible'               => true,
                'searchable'            => false,
                'filterable'            => false,
                'comparable'            => false,
                'visible_on_front'      => true,
                'wysiwyg_enabled'       => false,
                'is_html_allowed_on_front' => false,
                'global'                => ScopedAttributeInterface::SCOPE_STORE,
                'sort_order'            => 20,
            ],

            'Fahim_menu_block_left' => [
                'group'                 => 'Menu',
                'label'                 => 'Left Block',
                'note'                  => '',

                'type'                  => 'text',
                'frontend'              => '',
                'input'                 => 'textarea',

                'user_defined'          => true,
                'required'              => false,
                'visible'               => true,
                'searchable'            => false,
                'filterable'            => false,
                'comparable'            => false,
                'visible_on_front'      => true,
                'wysiwyg_enabled'       => true,
                'is_html_allowed_on_front' => true,
                'global'                => ScopedAttributeInterface::SCOPE_STORE,
                'sort_order'            => 310,
            ],

            'Fahim_menu_width_right' => [
                'group'                 => 'Menu',
                'label'                 => 'Right Block Width',
                'note'                  => "Right Block",
                'backend'               => '',
                'type'                  => 'varchar',
                'frontend'              => '',
                'input'                 => 'text',
                'user_defined'          => true,
                'required'              => false,
                'visible'               => true,
                'searchable'            => false,
                'filterable'            => false,
                'comparable'            => false,
                'visible_on_front'      => true,
                'wysiwyg_enabled'       => false,
                'is_html_allowed_on_front' => false,
                'global'                => ScopedAttributeInterface::SCOPE_STORE,
                'sort_order'            => 20,
            ],


            'Fahim_menu_block_right' => [
                'group'                 => 'Menu',
                'label'                 => 'Right Block',
                'note'                  => '',

                'type'                  => 'text',
                'frontend'              => '',
                'input'                 => 'textarea',

                'user_defined'          => true,
                'required'              => false,
                'visible'               => true,
                'searchable'            => false,
                'filterable'            => false,
                'comparable'            => false,
                'visible_on_front'      => true,
                'wysiwyg_enabled'       => true,
                'is_html_allowed_on_front' => true,
                'global'                => ScopedAttributeInterface::SCOPE_STORE,
                'sort_order'            => 320,
            ],

        ];

        return $attributes;                     
    }
}
