<?php

namespace Fahim\MegaMenu\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Index extends \Magento\Framework\View\Element\Template

{
    protected $templateProcessor;

	public function __construct(
        Context $context,
        \Zend_Filter_Interface $templateProcessor,
        CategoryRepository $categoryRepository,
        CategoryFactory $categoryFactory,
        CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
		$this->_categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->templateProcessor = $templateProcessor;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
        $this->registry = $registry;
    }
    public function getCategoryCollection($id)
    {
 
        $categoryObj = $this->categoryRepository->get($id);
        $collection = $categoryObj->getChildrenCategories();
        return $collection;
    }
    public function getCatDetails($id)
    {
 
        $collection = $this->collectionFactory->create()->addAttributeToSelect('*')->addAttributeToFilter('entity_id',['eq'=>$id])->setPageSize(1)->getFirstItem();

        return $collection;
    }
    public function filterOutputHtml($string) 
    {
        return $this->templateProcessor->filter($string);
    }
    public function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
    }
}


//  $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
// $catId = 5; // category id 

// $collection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory')
//                 ->create()
//                 ->addAttributeToSelect('*')
//                 ->addAttributeToFilter('entity_id',['eq'=>$catId])
//                 ->setPageSize(1);

// $catObj = $collection->getFirstItem();
// $catData = $catObj->getData(); // dump this line to check all data


// print_r($catData);
 