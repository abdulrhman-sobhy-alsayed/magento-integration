<?php
namespace PocketUp\User\Model\Config\Source;

class Events implements \Magento\Framework\Option\ArrayInterface
{
    private $statuses;

    public function __construct(\Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory $statuses)
    {
        $this->statuses=$statuses;
    }

    /**
     * Retrieve Custom Option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->statuses->create()->toOptionArray();
//        return [
//            ['value' => 'login', 'label' => 'Login'],
//            ['value' => 'logout', 'label' => 'Logout'],
//            ['value' => 'checkout', 'label' => 'Checkout']
//        ];
    }
}
